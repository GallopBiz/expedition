<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ExpeditingFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
        /**
         * Show the form for creating a new expediting form.
         */
        public function create()
        {
            $suppliers = \App\Models\User::where('role', 'Supplier')->get(['id', 'name', 'email']);
            return view('expediting_forms.create', compact('suppliers'));
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
                'work_package' => 'required|string|max:255',
                'lli' => 'nullable|boolean',
                'expediting_category' => 'required|string|max:255',
                'workpackage_name' => 'required|string|max:255',
                'supplier' => 'required|string|max:255',
                'order_date' => 'nullable|date',
                'contract_data_available_dmcs' => 'nullable|boolean',
                'po_number' => 'nullable|string|max:255',
                'incoterms' => 'nullable|string|max:255',
                'exyte_procurement_contract_manager' => 'nullable|string|max:255',
                'customer_procurement_contact' => 'nullable|string|max:255',
                'kickoff_status' => 'nullable|string|max:255',
                'technical_workpackage_owner' => 'nullable|string|max:255',
                'workstream_building' => 'nullable|string|max:255',
                'expediting_contact' => 'nullable|string|max:255',
            ]);

            $validated['created_by'] = auth()->user()->name;

            ExpeditingForm::create($validated);

            return redirect()->route('expediting_forms.create')->with('success', 'Expediting form created successfully.');
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
}
