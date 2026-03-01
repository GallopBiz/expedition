<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingEquipment;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\ExpeditingContext;
use App\Models\User;
use App\Mail\SupplierExpeditingFormLink;
use App\Models\ExpeditingFormEmailLog;

class ExpeditingEquipmentController extends Controller
{
        public function store(Request $request)
        {
            // Helper: fetch expediting_form_id from context_id if not provided or invalid
            $formId = $request->input('expediting_form_id');
            $contextId = $request->input('context_id');
            if ($formId && !\App\Models\ExpeditingForm::find($formId)) {
                // Try to fetch by context_id
                $form = \App\Models\ExpeditingForm::where('context_id', $contextId)->first();
                if ($form) {
                    \Log::info('Correcting expediting_form_id from context_id', ['old' => $formId, 'new' => $form->id]);
                    $request->merge(['expediting_form_id' => $form->id]);
                } else {
                    \Log::error('No expediting_form found for context_id', ['context_id' => $contextId]);
                }
                }
        \Log::info('Equipment creation request payload', ['payload' => $request->all()]);
        try {
            $validated = $request->validate([
            'expediting_form_id' => 'required|exists:expediting_forms,id',
            'context_id' => 'required|exists:expediting_contexts,id',
            'name' => 'required|string|max:255',
            'design' => 'nullable|integer',
            'material' => 'nullable|integer',
            'fab' => 'nullable|integer',
            'fat' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'subsupplier' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'place' => 'nullable|string|max:255',
            'order_status' => 'nullable|string|max:255',
            'drawing' => 'nullable|string|max:255',
            'scope' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'duration' => 'nullable|integer',
            'fatdate' => 'nullable|date',
            'contractualdate' => 'nullable|date',
            'actualdate' => 'nullable|date',
            'neededsite' => 'nullable|date',
            'openpoints' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'checks' => 'nullable|array',
        ]);
            $validated['checks'] = $request->input('checks', []);
            \Log::info('Equipment validated data', ['validated' => $validated]);
            $equipment = ExpeditingEquipment::create($validated);
            \Log::info('Equipment created successfully', ['equipment' => $equipment]);
            return response()->json(['success' => true, 'equipment' => $equipment]);
        } catch (\Exception $e) {
            \Log::error('Equipment creation error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
    public function update(Request $request, ExpeditingEquipment $equipment)
    {
        $validated = $request->validate([
            'expediting_form_id' => 'required|exists:expediting_forms,id',
            'context_id' => 'required|exists:expediting_contexts,id',
            'name' => 'required|string|max:255',
            'design' => 'nullable|integer',
            'material' => 'nullable|integer',
            'fab' => 'nullable|integer',
            'fat' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'subsupplier' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'place' => 'nullable|string|max:255',
            'order_status' => 'nullable|string|max:255',
            'drawing' => 'nullable|string|max:255',
            'scope' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'duration' => 'nullable|integer',
            'fatdate' => 'nullable|date',
            'contractualdate' => 'nullable|date',
            'actualdate' => 'nullable|date',
            'neededsite' => 'nullable|date',
            'openpoints' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'checks' => 'nullable|array',
        ]);
        $validated['checks'] = $request->input('checks', []);
        $equipment->update($validated);
        return response()->json(['success' => true, 'equipment' => $equipment]);
    }

    public function list(Request $request)
    {
        $formId = $request->input('expediting_form_id');
        if (!$formId) return response()->json([]);
        $equipments = ExpeditingEquipment::where('expediting_form_id', $formId)->get();
        return response()->json($equipments);
    }

    /**
     * Send a one-time supplier email with a secure, expiring auto-login link for equipment context.
     */
    public function sendSupplierEmail(Request $request)
    {
        $contextId = $request->input('context_id');
        $context = ExpeditingContext::find($contextId);
        if (!$context) {
            return response()->json(['error' => 'Context not found.'], 404);
        }
        // Find supplier user by name or email
        $supplier = User::where('name', $context->supplier)
            ->orWhere('email', $context->supplier)
            ->first();
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        }
        // Generate direct URL to supplier work package (no signed route needed)
        $link = url('/supplier/expedition-v2?context_id=' . $contextId . '&edit=1');
        // Send email using SMTP
        Mail::to($supplier->email)->send(new SupplierExpeditingFormLink($supplier->name, $link, $context));
        // Log email
        ExpeditingFormEmailLog::create([
            'expediting_form_id' => $contextId,
            'recipient_email' => $supplier->email,
            'sent_by' => auth()->check() ? auth()->user()->email : 'system',
            'sent_at' => now(),
            'subject' => 'Expediting Form Link',
            'message' => $link,
        ]);
        return response()->json(['success' => true]);
    }
}
