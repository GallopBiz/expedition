<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\SupplierExpeditingFormLink;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ExpeditingContext;
use App\Models\ExpeditingForm;




class ExpeditingFormController extends Controller
{
    /**
     * Allow supplier to access their expediting form via secure link.
     */
    public function supplierAccess(Request $request, ExpeditingForm $expeditingForm)
    {
        // Optionally, you can add extra checks here (e.g., mark as viewed, log access, etc.)
        return view('expediting_forms.supplier_access', compact('expeditingForm'));
    }

    /**
     * Send a professional email to the supplier with a secure, expiring auto-login link.
     */
    public function sendEmail(Request $request, ExpeditingForm $expeditingForm)
    {
        // Find supplier user by name or email (adjust as needed)
        $supplier = User::where('name', $expeditingForm->supplier)
            ->orWhere('email', $expeditingForm->supplier)
            ->first();
        if (!$supplier) {
            return redirect()->back()->with('error', 'Supplier not found.');
        }

        // Generate signed URL (valid for 48 hours)
        $link = URL::signedRoute('supplier.expedite.access', ['expeditingForm' => $expeditingForm->id], now()->addHours(48));

        // Send email
        Mail::to($supplier->email)->send(new SupplierExpeditingFormLink($supplier->name, $link, $expeditingForm));

        return redirect()->back()->with('success', 'Email sent to supplier successfully.');
    }
    /**
     * Display a listing of the resource.
     */
        /**
     * Show all submitted expediting forms in a list.
     */
    public function list()
    {
        $expeditingForms = ExpeditingForm::orderByDesc('created_at')->get();
        return view('expediting_forms.list', compact('expeditingForms'));
    }

    /**
     * Show the form for creating a new resource.
     */
        /**
         * Show the form for creating a new expediting form.
         */
    
    public function create()
    {
        $suppliers = User::where('role', 'Supplier')->get(['id', 'name', 'email']);
        $expeditors = User::where('role', 'Expeditor')->get(['id', 'name', 'email']);
        $workpackageNames = ExpeditingContext::distinct()->pluck('workpackage_name');
        $poNumbers = ExpeditingContext::distinct()->pluck('po_number');
        $customerContacts = ExpeditingContext::distinct()->pluck('customer_procurement_contact');
        $technicalOwners = ExpeditingContext::distinct()->pluck('technical_workpackage_owner');
        return view('expediting_forms.create', compact('suppliers', 'expeditors', 'workpackageNames', 'poNumbers', 'customerContacts', 'technicalOwners'));
    }


    /**
     * Store a newly created resource in storage.
     */
        /**
         * Store a newly created expediting form in storage.
         */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Context fields
            'workpackage_name' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'po_number' => 'required|string|max:255',
            'lli' => 'nullable',
            'expediting_category' => 'nullable',
            'order_date' => 'nullable|date',
            'contract_data_available_dmcs' => 'nullable',
            'incoterms' => 'nullable',
            'exyte_procurement_contract_manager' => 'nullable',
            'customer_procurement_contact' => 'nullable',
            'kickoff_status' => 'nullable',
            'technical_workpackage_owner' => 'nullable',
            // Execution lines
            'executions' => 'required|array|min:1',
            'executions.*.work_package' => 'required|string|max:255',
            'executions.*.workstream_building' => 'required|string|max:255',
            'executions.*.expediting_contact' => 'required|string|max:255',
        ]);

        // Find or create context
        $context = ExpeditingContext::firstOrCreate(
            [
                'supplier' => $validated['supplier'],
                'workpackage_name' => $validated['workpackage_name'],
                'po_number' => $validated['po_number'],
            ],
            [
                'lli' => $validated['lli'] ?? null,
                'expediting_category' => $validated['expediting_category'] ?? null,
                'order_date' => $validated['order_date'] ?? null,
                'contract_data_available_dmcs' => $validated['contract_data_available_dmcs'] ?? null,
                'incoterms' => $validated['incoterms'] ?? null,
                'exyte_procurement_contract_manager' => $validated['exyte_procurement_contract_manager'] ?? null,
                'customer_procurement_contact' => $validated['customer_procurement_contact'] ?? null,
                'kickoff_status' => $validated['kickoff_status'] ?? null,
                'technical_workpackage_owner' => $validated['technical_workpackage_owner'] ?? null,
            ]
        );

        $errors = [];
        foreach ($validated['executions'] as $i => $exec) {
            // Prevent duplicate execution for this context
            $exists = ExpeditingForm::where('context_id', $context->id)
                ->where('work_package', $exec['work_package'])
                ->where('workstream_building', $exec['workstream_building'])
                ->exists();
            if ($exists) {
                $errors[] = "Duplicate execution for Work Package '{$exec['work_package']}' and Building '{$exec['workstream_building']}' (row ".($i+1).")";
                continue;
            }
            ExpeditingForm::create([
                'context_id' => $context->id,
                'work_package' => $exec['work_package'],
                'workstream_building' => $exec['workstream_building'],
                'expediting_contact' => $exec['expediting_contact'],
                'created_by' => auth()->user() ? auth()->user()->name : 'system',
                'expediting_category' => $context->expediting_category,
                'workpackage_name' => $context->workpackage_name,
                'supplier' => $context->supplier,
                'order_date' => $context->order_date,
                'contract_data_available_dmcs' => $context->contract_data_available_dmcs,
                'po_number' => $context->po_number,
                'incoterms' => $context->incoterms,
                'exyte_procurement_contract_manager' => $context->exyte_procurement_contract_manager,
                'customer_procurement_contact' => $context->customer_procurement_contact,
                'kickoff_status' => $context->kickoff_status,
                'technical_workpackage_owner' => $context->technical_workpackage_owner,
            ]);
        }

        if (count($errors)) {
            return redirect()->back()->withErrors(['executions' => $errors])->withInput();
        }

        return redirect()->route('expediting_forms.create')->with('success', 'Expediting form and executions created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpeditingForm $expeditingForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpeditingForm $expeditingForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpeditingForm $expeditingForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpeditingForm $expeditingForm)
    {
        //
    }

    /**
     * AJAX endpoint to check for reusable context.
     * Returns { exists: bool, data: context fields or null }
     */
    public function checkContext(Request $request)
    {
        $request->validate([
            'supplier' => 'required|string',
            'workpackage_name' => 'required|string',
            'po_number' => 'required|string',
        ]);
        $context = ExpeditingContext::where('supplier', $request->supplier)
            ->where('workpackage_name', $request->workpackage_name)
            ->where('po_number', $request->po_number)
            ->first();
        if ($context) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'lli' => $context->lli,
                    'expediting_category' => $context->expediting_category,
                    'order_date' => $context->order_date,
                    'contract_data_available_dmcs' => $context->contract_data_available_dmcs,
                    'incoterms' => $context->incoterms,
                    'exyte_procurement_contract_manager' => $context->exyte_procurement_contract_manager,
                    'customer_procurement_contact' => $context->customer_procurement_contact,
                    'kickoff_status' => $context->kickoff_status,
                    'technical_workpackage_owner' => $context->technical_workpackage_owner,
                ]
            ]);
        } else {
            return response()->json(['exists' => false, 'data' => null]);
        }
    }

}
