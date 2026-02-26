<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingContext;

class ExpeditingContextController extends Controller
{
    public function saveOrUpdate(Request $request)
    {
        $contextId = $request->input('context_id');
        $rules = [
            'work_package_no' => 'required',
            'workstream_building' => 'nullable',
            // ...other rules...
        ];
        // Unique validation for update (ignore current context)
        $rules['work_package_no'] .= '|unique:expediting_contexts,work_package_no,' . ($contextId ?: 'NULL') . ',id,workstream_building,' . $request->workstream_building;

        $validated = $request->validate($rules);
        $data = $request->only([
            'supplier',
            'workpackage_name',
            'work_package_no',
            'po_number',
            'expediting_category',
            'order_date',
            'incoterms',
            'exyte_procurement_contract_manager',
            'customer_procurement_contact',
            'technical_workpackage_owner',
            'forecast_delivery_to_site',
            'workstream_building',
        ]);
        // Store toggles as 1 or 0
        $data['lli'] = $request->has('lli') ? 1 : 0;
        $data['contract_data_available_dmcs'] = $request->has('contract_data_available_dmcs') ? 1 : 0;
        $data['kickoff_status'] = $request->has('kickoff_status') ? 1 : 0;
        $data['delivered'] = $request->has('delivered');

        if ($contextId && ($context = ExpeditingContext::find($contextId))) {
            $context->update($data);
        } else {
            $context = ExpeditingContext::create($data);
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'context_id' => $context->id,
            ]);
        }
        return redirect()->back()->with('status', 'Work package saved successfully.');
    }
}
