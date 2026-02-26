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
        // Generate signed URL (valid for 48 hours)
        $link = URL::signedRoute('supplier.expedition_v2', ['context_id' => $contextId], now()->addHours(48));
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
