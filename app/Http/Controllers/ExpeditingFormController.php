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
     * Show the new modern supplier expedition form (for suppliers)
     */
    public function supplierExpeditionModern(Request $request)
    {
        // Get the logged-in supplier's name or email
        $supplier = auth()->user()->name ?? auth()->user()->email;

        // Group by parent workpackage_name, fetch all children for this supplier
        $parentGroups = ExpeditingForm::where('supplier', $supplier)
            ->orderBy('workpackage_name')
            ->get()
            ->groupBy('workpackage_name');

        // Optionally, fetch parent context for each group (for parent-level details)
        $parentContexts = [];
        foreach ($parentGroups as $parentName => $children) {
            $parentContexts[$parentName] = $children->first()->context ?? null;
        }

        return view('expediting_forms.supplier_access_modern', [
            'parentGroups' => $parentGroups,
            'parentContexts' => $parentContexts,
        ]);
    }

    /**
     * Handle submission of the new modern supplier expedition form (for suppliers)
     */
    public function supplierExpeditionModernSubmit(Request $request)
    {
        // Validate and save the form data (customize as needed)
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'po_number' => 'required|string|max:255',
            'work_package' => 'required|string|max:255',
            'material_desc' => 'required|string|max:255',
            'delivery_location' => 'required|string|max:255',
            'po_date' => 'required|date',
            'planned_delivery' => 'required|date',
            'forecast_delivery' => 'nullable|date',
            'actual_delivery' => 'nullable|date',
            'comments' => 'nullable|string|max:1000',
        ]);

        // Save to a new table/model or log as needed (for demo, just flash success)
        // Example: SupplierExpeditionModern::create($validated);

        return redirect()->back()->with('success', 'Supplier expedition form submitted successfully!');
    }
    /**
     * Allow supplier to access their expediting form via secure link.
     */
    public function supplierAccess(Request $request, ExpeditingForm $expeditingForm)
    {
        // If already submitted, show expired alert only for guests
        $actualDeliveryHistories = $expeditingForm->actualDeliveryHistories()
            ->orderByDesc('changed_at')
            ->get();
        if ($expeditingForm->email_link_submitted) {
            if (!auth()->check() || auth()->user()->role !== 'Supplier' || auth()->user()->email !== $expeditingForm->supplier) {
                return view('expediting_forms.supplier_access', [
                    'expeditingForm' => $expeditingForm,
                    'linkExpired' => true,
                    'actualDeliveryHistories' => $actualDeliveryHistories,
                ]);
            }
        }
        $dateHistories = $expeditingForm->dateHistories()
            ->orderByDesc('changed_at')
            ->get();
        $emailLogs = $expeditingForm->emailLogs()
            ->orderByDesc('sent_at')
            ->get();
        return view('expediting_forms.supplier_access', [
            'expeditingForm' => $expeditingForm,
            'linkExpired' => false,
            'dateHistories' => $dateHistories,
            'emailLogs' => $emailLogs,
            'actualDeliveryHistories' => $actualDeliveryHistories,
        ]);
    }

        // API: Get all work packages and their equipment for a context
    public function getWorkPackagesByContext(Request $request)
    {
        $context_id = $request->query('context_id');
        if (!$context_id) {
            return response()->json([], 404);
        }
        $workPackages = \App\Models\ExpeditingForm::where('context_id', $context_id)->get();
        $result = $workPackages->map(function($pkg) {
            $equipments = \App\Models\ExpeditingEquipment::where('expediting_form_id', $pkg->id)->get();
            return [
                'workpackage_name' => $pkg->workpackage_name,
                'equipments' => $equipments->map(function($eq) {
                    return [
                        'name' => $eq->name,
                        'contractualdate' => $eq->contractualdate,
                        'actualdate' => $eq->actualdate,
                        'fatdate' => $eq->fatdate,
                    ];
                }),
            ];
        });
        return response()->json($result);
    }

    /**
     * Handle supplier form submission and log date changes.
     */
    public function supplierUpdate(Request $request, ExpeditingForm $expeditingForm)
    {
        // Track changes for 'actual_delivery_to_site_supplier'
        $oldActualDelivery = $expeditingForm->actual_delivery_to_site_supplier;
        $newActualDelivery = $request->input('actual_delivery_to_site_supplier');
        if ($oldActualDelivery != $newActualDelivery) {
            \App\Models\ExpeditingFormActualDeliveryHistory::create([
                'expediting_form_id' => $expeditingForm->id,
                'old_value' => $oldActualDelivery,
                'new_value' => $newActualDelivery,
                'changed_by' => auth()->check() ? auth()->user()->email : ($expeditingForm->supplier ?? 'guest'),
                'changed_at' => now(),
            ]);
        }

        // Track changes for 'forecast_delivery_to_site'
        $oldForecastDelivery = $expeditingForm->forecast_delivery_to_site;
        $newForecastDelivery = $request->input('forecast_delivery_to_site');
        if ($oldForecastDelivery != $newForecastDelivery) {
            // Prevent duplicate consecutive entries for the same new value
            $lastHistory = $expeditingForm->forecastDeliveryHistories()->orderByDesc('changed_at')->first();
            if (!$lastHistory || $lastHistory->new_value != $newForecastDelivery) {
                \App\Models\ExpeditingFormForecastDeliveryHistory::create([
                    'expediting_form_id' => $expeditingForm->id,
                    'old_value' => $oldForecastDelivery,
                    'new_value' => $newForecastDelivery,
                    'changed_by' => auth()->check() ? auth()->user()->email : ($expeditingForm->supplier ?? 'guest'),
                    'changed_at' => now(),
                ]);
            }
        }
        // ...existing code...
        $editableFields = [
            'equipment_type_tag_number',
            'detailed_scope_of_delivery',
            'quantity',
            'supplier',
            'sub_supplier',
            'place_of_manufacturing',
            'order_status',
            'drawing_approval',
            'design_status',
            'material_status',
            'fabrication_status',
            'fat_status',
            'start_of_manufacturing_actual',
            'end_of_manufacturing',
            'fat_date_actual',
            'contractual_delivery_to_site_date',
            'actual_delivery_to_site_supplier',
            'manufacturing_duration',
            'ready_for_shipment',
            'storage_at_supplier',
            'delivered',
            'comments',
        ];
        $validated = $request->validate([
            'equipment_type_tag_number' => 'nullable|string|max:255',
            'detailed_scope_of_delivery' => 'nullable|string',
            'quantity' => 'nullable|numeric',
            'supplier' => 'nullable|string|max:255',
            'sub_supplier' => 'nullable|string|max:255',
            'place_of_manufacturing' => 'nullable|string|max:255',
            'order_status' => 'nullable|string',
            'drawing_approval' => 'nullable|string',
            'design_status' => 'nullable|integer|min:0|max:100',
            'material_status' => 'nullable|integer|min:0|max:100',
            'fabrication_status' => 'nullable|integer|min:0|max:100',
            'fat_status' => 'nullable|integer|min:0|max:100',
            'start_of_manufacturing_actual' => 'nullable|date',
            'end_of_manufacturing' => 'nullable|date',
            'fat_date_actual' => 'nullable|date',
            'contractual_delivery_to_site_date' => 'nullable|date',
            'actual_delivery_to_site_supplier' => 'nullable|date',
            'manufacturing_duration' => 'nullable|numeric',
            'ready_for_shipment' => 'nullable|in:Yes,No',
            'storage_at_supplier' => 'nullable|in:Yes,No',
            'delivered' => 'nullable|in:Yes,No,Delay- FAT Issue,Other',
            'comments' => 'nullable|string',
        ]);
        // ...existing code...
        $supplierEmail = $expeditingForm->supplier;
        $userIdentifier = auth()->check() ? auth()->user()->email : $supplierEmail;
        $now = now();
        foreach ($editableFields as $field) {
            if (array_key_exists($field, $validated)) {
                $old = $expeditingForm->$field;
                $new = $validated[$field];
                if ($old != $new) {
                    \App\Models\ExpeditingFormHistory::create([
                        'expediting_form_id' => $expeditingForm->id,
                        'field_changed' => $field,
                        'old_value' => $old,
                        'new_value' => $new,
                        'changed_by' => $userIdentifier,
                        'changed_at' => $now,
                    ]);
                }
            }
        }
        // ...existing code...
        $expeditingForm->fill(array_intersect_key($validated, array_flip($editableFields)));
        $expeditingForm->email_link_submitted = true;
        $expeditingForm->save();

        // Notify all managers
        $managers = \App\Models\User::where('role', 'Manager')->get();
        foreach ($managers as $manager) {
            \App\Models\Notification::create([
                'user_id' => $manager->id,
                'title' => 'Supplier Form Submitted',
                'body' => 'A supplier has submitted a form for Work Package: ' . $expeditingForm->work_package,
                'url' => route('expediting_forms.cards', ['#workpackage-' . $expeditingForm->id]),
                'read' => false,
            ]);
        }

        return redirect()->back()->with('success', 'Form updated successfully.');
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

        // Reset link submitted so supplier can fill again
        $expeditingForm->email_link_submitted = false;
        $expeditingForm->save();

        // Generate signed URL (valid for 48 hours)
        $link = URL::signedRoute('supplier.expedite.access', ['expeditingForm' => $expeditingForm->id], now()->addHours(48));

        // Send email
        Mail::to($supplier->email)->send(new SupplierExpeditingFormLink($supplier->name, $link, $expeditingForm));

        \App\Models\ExpeditingFormEmailLog::create([
            'expediting_form_id' => $expeditingForm->id,
            'recipient_email' => $supplier->email,
            'sent_by' => auth()->check() ? auth()->user()->email : 'system',
            'sent_at' => now(),
            'subject' => 'Expediting Form Submission Link',
            'message' => $link,
        ]);

        return redirect()->back()->with('success', 'Email sent to supplier successfully.');
    }

    // Show all submitted expediting forms in a list.
    public function list()
    {
        $query = ExpeditingForm::query();

        // Filter: Expediting Category
        if (request()->filled('filter_category')) {
            $query->where(function($q) {
                $q->where('expediting_category', request('filter_category'))
                  ->orWhereHas('context', function($cq) {
                      $cq->where('expediting_category', request('filter_category'));
                  });
            });
        }

        // Filter: Supplier
        if (request()->filled('filter_supplier')) {
            $query->where(function($q) {
                $q->where('supplier', 'like', '%'.request('filter_supplier').'%')
                  ->orWhereHas('context', function($cq) {
                      $cq->where('supplier', 'like', '%'.request('filter_supplier').'%');
                  });
            });
        }
        
            // Filter: Delivered
            if (request()->filled('filter_delivered')) {
                $query->where('delivered', request('filter_delivered'));
            }

            // Filter: Sub Supplier
            if (request()->filled('filter_sub_supplier')) {
                $query->where('sub_supplier', 'like', '%'.request('filter_sub_supplier').'%');
            }

            // Search: Work Package
            if (request()->filled('search_work_package')) {
                $query->where('work_package', 'like', '%'.request('search_work_package').'%');
            }

            // Search: Equipment Type / Tag Number
            if (request()->filled('search_equipment_type')) {
                $query->where('equipment_type_tag_number', 'like', '%'.request('search_equipment_type').'%');
            }

        // Filter: Order Date (from/to)
        if (request()->filled('filter_order_date_from') || request()->filled('filter_order_date_to')) {
            $query->whereHas('context', function($cq) {
                if (request()->filled('filter_order_date_from')) {
                    $cq->whereDate('order_date', '>=', request('filter_order_date_from'));
                }
                if (request()->filled('filter_order_date_to')) {
                    $cq->whereDate('order_date', '<=', request('filter_order_date_to'));
                }
            });
        }

        // Search: Workpackage Name
        if (request()->filled('search_workpackage_name')) {
            $query->where(function($q) {
                $q->where('workpackage_name', 'like', '%'.request('search_workpackage_name').'%')
                  ->orWhereHas('context', function($cq) {
                      $cq->where('workpackage_name', 'like', '%'.request('search_workpackage_name').'%');
                  });
            });
        }

        // Search: PO Number
        if (request()->filled('search_po_number')) {
            $query->where(function($q) {
                $q->where('po_number', 'like', '%'.request('search_po_number').'%')
                  ->orWhereHas('context', function($cq) {
                      $cq->where('po_number', 'like', '%'.request('search_po_number').'%');
                  });
            });
        }

        $expeditingForms = $query->orderByDesc('created_at')->get();

        // For supplier dropdown
        $supplierList = ExpeditingForm::distinct()->pluck('supplier')->filter()->unique();
            // Attach supplier email to each form for card display
            foreach ($expeditingForms as $form) {
                $supplierUser = \App\Models\User::where('role', 'Supplier')->where('name', $form->supplier)->first();
                $form->supplier_email = $supplierUser ? $supplierUser->email : null;
            }
            return view('expediting_forms.list', compact('expeditingForms', 'supplierList'));
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
            'work_package_no' => 'nullable|string|max:255',
            'supplier' => 'required|string|max:255',
            'po_number' => 'nullable|string|max:255',
            'lli' => 'nullable',
            'expediting_category' => 'nullable',
            'order_date' => 'nullable|date',
            'contract_data_available_dmcs' => 'nullable',
            'incoterms' => 'nullable',
            'exyte_procurement_contract_manager' => 'nullable',
            'customer_procurement_contact' => 'nullable',
            'kickoff_status' => 'nullable|string|max:255',
            'technical_workpackage_owner' => 'nullable|string|max:255',
            'forecast_delivery_to_site' => 'nullable|date',
            // Execution lines
            'executions' => 'required|array|min:1',
            'executions.*.work_package' => 'required|string|max:255',
            'executions.*.workstream_building' => 'required|string|max:255',
            'executions.*.expediting_contact' => 'required|string|max:255',
        ]);

        // Ensure empty PO Number is saved as empty string, not null or '?'
        if (!isset($validated['po_number']) || $validated['po_number'] === null || $validated['po_number'] === '?') {
            $validated['po_number'] = '';
        }

        // Find or create context
        $context = ExpeditingContext::firstOrCreate(
            [
                'supplier' => $validated['supplier'],
                'workpackage_name' => $validated['workpackage_name'],
                'po_number' => $validated['po_number'],
            ],
            [
                'work_package_no' => $validated['work_package_no'] ?? null,
                'lli' => $validated['lli'] ?? null,
                'expediting_category' => $validated['expediting_category'] ?? null,
                'order_date' => $validated['order_date'] ?? null,
                'contract_data_available_dmcs' => $validated['contract_data_available_dmcs'] ?? null,
                'incoterms' => $validated['incoterms'] ?? null,
                'exyte_procurement_contract_manager' => $validated['exyte_procurement_contract_manager'] ?? null,
                'customer_procurement_contact' => $validated['customer_procurement_contact'] ?? null,
                'kickoff_status' => $validated['kickoff_status'] ?? null,
                'technical_workpackage_owner' => $validated['technical_workpackage_owner'] ?? null,
                'forecast_delivery_to_site' => $validated['forecast_delivery_to_site'] ?? null,
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
                'forecast_delivery_to_site' => $context->forecast_delivery_to_site,
            ]);
        }

        // If ajaxform=1, return JSON response with context_id
        if ($request->input('ajaxform') == 1) {
            if (count($errors)) {
                return response()->json(['success' => false, 'errors' => $errors], 422);
            }
            return response()->json(['success' => true, 'context_id' => $context->id]);
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
        $suppliers = \App\Models\User::where('role', 'Supplier')->get(['id', 'name', 'email']);
        $expeditors = \App\Models\User::where('role', 'Expeditor')->get(['id', 'name', 'email']);
        $workpackageNames = \App\Models\ExpeditingContext::distinct()->pluck('workpackage_name');
        $poNumbers = \App\Models\ExpeditingContext::distinct()->pluck('po_number');
        $customerContacts = \App\Models\ExpeditingContext::distinct()->pluck('customer_procurement_contact');
        $technicalOwners = \App\Models\ExpeditingContext::distinct()->pluck('technical_workpackage_owner');
        return view('expediting_forms.create', [
            'expeditingForm' => $expeditingForm,
            'suppliers' => $suppliers,
            'expeditors' => $expeditors,
            'workpackageNames' => $workpackageNames,
            'poNumbers' => $poNumbers,
            'customerContacts' => $customerContacts,
            'technicalOwners' => $technicalOwners,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpeditingForm $expeditingForm)
    {
        $validated = $request->validate([
            'work_package' => 'required|string|max:255',
            'workstream_building' => 'nullable|string|max:255',
            'expediting_contact' => 'nullable|string|max:255',
            'expediting_category' => 'nullable|string|max:255',
            'workpackage_name' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'order_date' => 'nullable|date',
            'contract_data_available_dmcs' => 'nullable',
            'po_number' => 'nullable|string|max:255',
            'incoterms' => 'nullable|string|max:255',
            'exyte_procurement_contract_manager' => 'nullable|string|max:255',
            'customer_procurement_contact' => 'nullable|string|max:255',
            'kickoff_status' => 'nullable|string|max:255',
            'technical_workpackage_owner' => 'nullable|string|max:255',
            'forecast_delivery_to_site' => 'nullable|date',
            'lli' => 'nullable',
            'executions' => 'required|array|min:1',
            'executions.*.work_package' => 'required|string|max:255',
            'executions.*.workstream_building' => 'required|string|max:255',
            'executions.*.expediting_contact' => 'required|string|max:255',
            'executions.*.id' => 'nullable|integer|exists:expediting_forms,id',
        ]);

        // Track changes for 'forecast_delivery_to_site' (history)
        $oldForecastDelivery = $expeditingForm->forecast_delivery_to_site;
        $newForecastDelivery = $validated['forecast_delivery_to_site'] ?? null;
        if ($oldForecastDelivery != $newForecastDelivery) {
            \App\Models\ExpeditingFormForecastDeliveryHistory::create([
                'expediting_form_id' => $expeditingForm->id,
                'old_value' => $oldForecastDelivery,
                'new_value' => $newForecastDelivery,
                'changed_by' => auth()->check() ? auth()->user()->email : 'system',
                'changed_at' => now(),
            ]);
        }
        // Update context fields for all executions in this context
        $contextId = $expeditingForm->context_id;
        $contextFields = [
            'expediting_category', 'workpackage_name', 'supplier', 'order_date', 'contract_data_available_dmcs',
            'po_number', 'incoterms', 'exyte_procurement_contract_manager', 'customer_procurement_contact',
            'kickoff_status', 'technical_workpackage_owner', 'forecast_delivery_to_site', 'lli'
        ];
        $contextData = [];
        foreach ($contextFields as $field) {
            $contextData[$field] = $validated[$field] ?? null;
        }
        \App\Models\ExpeditingContext::where('id', $contextId)->update($contextData);

        // Get all existing executions for this context
        $existingExecutions = \App\Models\ExpeditingForm::where('context_id', $contextId)->get();
        $existingIds = $existingExecutions->pluck('id')->toArray();
        $submittedIds = collect($validated['executions'])->pluck('id')->filter()->map(fn($id) => (int)$id)->toArray();

        // Delete removed executions
        $toDelete = array_diff($existingIds, $submittedIds);
        if (count($toDelete)) {
            \App\Models\ExpeditingForm::whereIn('id', $toDelete)->delete();
        }

        // Update or create executions
        foreach ($validated['executions'] as $exec) {
            $data = [
                'context_id' => $contextId,
                'work_package' => $exec['work_package'],
                'workstream_building' => $exec['workstream_building'],
                'expediting_contact' => $exec['expediting_contact'],
            ];
            // Add context fields to each execution
            foreach ($contextFields as $field) {
                $data[$field] = $contextData[$field];
            }
            if (!empty($exec['id'])) {
                // Update existing
                \App\Models\ExpeditingForm::where('id', $exec['id'])->update($data);
            } else {
                // Create new
                $data['created_by'] = auth()->user() ? auth()->user()->name : 'system';
                \App\Models\ExpeditingForm::create($data);
            }
        }

        // Notify the related supplier (if exists)
        $supplier = null;
        if (!empty($contextData['supplier'])) {
            $supplier = \App\Models\User::where('email', $contextData['supplier'])
                ->orWhere('name', $contextData['supplier'])
                ->first();
        }
        if ($supplier) {
            \App\Models\Notification::create([
                'user_id' => $supplier->id,
                'title' => 'Work Package Updated',
                'body' => 'Your work package "' . ($contextData['workpackage_name'] ?? $expeditingForm->work_package) . '" has been updated by a Manager/Expeditor.',
                'url' => route('expediting_forms.cards', ['#workpackage-' . $expeditingForm->id]),
                'read' => false,
            ]);
        }

        return redirect()->route('expediting_forms.list')->with('success', 'Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpeditingForm $expeditingForm)
    {
        // Check for assigned values (supplier input columns)
        $blockedFields = [
            'detailed_scope_of_delivery', 'quantity', 'design_status', 'end_of_manufacturing_supplier',
            'manufacturing_status', 'fat_date_scheduled_baseline', 'fat_date_actual', 'fat_status',
            'ready_for_shipment', 'contractual_delivery_to_site_date', 'forecast_delivery_to_site',
            'actual_delivery_to_site_supplier', 'storage_requirement', 'delivery_postponement_due_to_site_readiness',
            'exyte_technical_discussion'
        ];
        $hasAssigned = false;
        foreach ($blockedFields as $field) {
            if (!empty($expeditingForm->$field)) {
                $hasAssigned = true;
                break;
            }
        }
        if ($hasAssigned) {
            return redirect()->route('expediting_forms.list')->with('error', 'Cannot delete: This work package has assigned values in expediting list.');
        }
        $expeditingForm->delete();
        return redirect()->route('expediting_forms.list')->with('success', 'Work package deleted successfully!');
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
        // Show all submitted expediting forms in a detailed expediting list (with supplier inputs)
    public function expeditingList(Request $request)
    {
        $query = ExpeditingForm::query();
        // Filter: Delivered
        if ($request->filled('filter_delivered')) {
            $query->where('delivered', $request->filter_delivered);
        }

        // Filter: Expediting Category
        if ($request->filled('filter_category')) {
            $query->where(function($q) use ($request) {
                $q->where('expediting_category', $request->filter_category)
                  ->orWhereHas('context', function($cq) use ($request) {
                      $cq->where('expediting_category', $request->filter_category);
                  });
            });
        }

        // Filter: Supplier
        if ($request->filled('filter_supplier')) {
            $query->where(function($q) use ($request) {
                $q->where('supplier', 'like', '%'.$request->filter_supplier.'%')
                  ->orWhereHas('context', function($cq) use ($request) {
                      $cq->where('supplier', 'like', '%'.$request->filter_supplier.'%');
                  });
            });
        }

        // Filter: Kick-off Status
        if ($request->filled('filter_kickoff')) {
            $query->whereHas('context', function($cq) use ($request) {
                $cq->where('kickoff_status', 'like', '%'.$request->filter_kickoff.'%');
            });
        }


        // Filter: Order Date (from/to)
        if ($request->filled('filter_order_date_from') || $request->filled('filter_order_date_to')) {
            $query->whereHas('context', function($cq) use ($request) {
                if ($request->filled('filter_order_date_from')) {
                    $cq->whereDate('order_date', '>=', $request->filter_order_date_from);
                }
                if ($request->filled('filter_order_date_to')) {
                    $cq->whereDate('order_date', '<=', $request->filter_order_date_to);
                }
            });
        }

        // Filter: Actual Delivery to site Supplier (from/to)
        if ($request->filled('filter_actual_delivery_from')) {
            $query->whereDate('actual_delivery_to_site_supplier', '>=', $request->filter_actual_delivery_from);
        }
        if ($request->filled('filter_actual_delivery_to')) {
            $query->whereDate('actual_delivery_to_site_supplier', '<=', $request->filter_actual_delivery_to);
        }

        // Search: PO Number
        if ($request->filled('search_po_number')) {
            $query->where(function($q) use ($request) {
                $q->where('po_number', 'like', '%'.$request->search_po_number.'%')
                  ->orWhereHas('context', function($cq) use ($request) {
                      $cq->where('po_number', 'like', '%'.$request->search_po_number.'%');
                  });
            });
        }

        // Search: Supplier (again, for search box)
        if ($request->filled('search_supplier')) {
            $query->where(function($q) use ($request) {
                $q->where('supplier', 'like', '%'.$request->search_supplier.'%')
                  ->orWhereHas('context', function($cq) use ($request) {
                      $cq->where('supplier', 'like', '%'.$request->search_supplier.'%');
                  });
            });
        }

        $expeditingForms = $query->orderByDesc('created_at')->get();
        // Get unique supplier names for dropdown
        $supplierList = ExpeditingForm::distinct()->orderBy('supplier')->pluck('supplier');
        return view('expediting_forms.expediting_list', compact('expeditingForms', 'supplierList'));
    }


}