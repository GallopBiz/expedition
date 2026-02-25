<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingForm;
use App\Models\ExpeditingEquipment;

class SupplierExpeditionV2Controller extends Controller
{
    public function show(Request $request)
    {
        $contextId = $request->query('context_id');
        $context = null;
        $equipments = collect();
        if ($contextId) {
            $context = \App\Models\ExpeditingContext::where('id', $contextId)->first();
            $equipments = \App\Models\ExpeditingEquipment::where('context_id', $contextId)->get();

            // Backfill missing context fields from expediting_forms
            if ($context) {
                $form = \App\Models\ExpeditingForm::where('context_id', $contextId)->first();
                if ($form) {
                    $fields = [
                        'identifier',
                        'workpackage_name',
                        'po_number',
                        'expediting_category',
                        'supplier',
                        'order_date',
                        'forecast_delivery_to_site',
                        'incoterms',
                        'exyte_procurement_contract_manager',
                        'customer_procurement_contact',
                        'technical_workpackage_owner',
                        'expediting_contact',
                        'workstream_building',
                    ];
                    foreach ($fields as $field) {
                        if (empty($context->$field) && !empty($form->$field)) {
                            $context->$field = $form->$field;
                        }
                    }
                }
            }
        }
        return view('expediting_forms.supplier_access_v2', [
            'context' => $context,
            'equipments' => $equipments,
        ]);
    }
}
