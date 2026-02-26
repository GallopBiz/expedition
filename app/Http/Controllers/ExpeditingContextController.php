<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingContext;
use App\Exports\WorkPackageExport;
use App\Models\ExpeditingEquipment;
use Maatwebsite\Excel\Facades\Excel;

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

    public function export(Request $request)
    {
        $contextId = $request->input('context_id');
        $context = ExpeditingContext::findOrFail($contextId);
        $equipments = ExpeditingEquipment::where('context_id', $contextId)->get();
        $export = new \App\Exports\WorkPackageExport($context, $equipments);
        $filename = 'workpackage_' . $context->work_package_no . '_export.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download($export, $filename);
    }

    public function exportAll()
    {
        $contexts = \App\Models\ExpeditingContext::all();
        $rows = [];
        foreach ($contexts as $context) {
            $equipments = \App\Models\ExpeditingEquipment::where('context_id', $context->id)->get();
            if ($equipments->count() === 0) {
                // Still output context row with empty equipment fields
                $rows[] = [
                    'Work Package No' => $context->work_package_no,
                    'Work Package Name' => $context->workpackage_name,
                    'Supplier' => $context->supplier,
                    'PO Number' => $context->po_number,
                    'Expediting Category' => $context->expediting_category,
                    'Order Date' => $context->order_date,
                    'Incoterms' => $context->incoterms,
                    'Forecast Delivery' => $context->forecast_delivery_to_site,
                    'Workstream/Building' => $context->workstream_building,
                    'Equipment Name' => '',
                    'Sub Supplier' => '',
                    'Quantity' => '',
                    'Place' => '',
                    'Order Status' => '',
                    'Drawing Approval' => '',
                    'Scope' => '',
                    'Design Status' => '',
                    'Material Status' => '',
                    'Fabrication Status' => '',
                    'FAT Status' => '',
                    'Start of Manufacturing' => '',
                    'End of Manufacturing' => '',
                    'FAT Date' => '',
                    'Contractual Delivery' => '',
                    'Actual Delivery' => '',
                    'Needed Delivery' => '',
                    'Open Points' => '',
                    'Remarks' => '',
                ];
            } else {
                foreach ($equipments as $eq) {
                    $rows[] = [
                        'Work Package No' => $context->work_package_no,
                        'Work Package Name' => $context->workpackage_name,
                        'Supplier' => $context->supplier,
                        'PO Number' => $context->po_number,
                        'Expediting Category' => $context->expediting_category,
                        'Order Date' => $context->order_date,
                        'Incoterms' => $context->incoterms,
                        'Forecast Delivery' => $context->forecast_delivery_to_site,
                        'Workstream/Building' => $context->workstream_building,
                        'Equipment Name' => $eq->name,
                        'Sub Supplier' => $eq->subsupplier,
                        'Quantity' => $eq->qty,
                        'Place' => $eq->place,
                        'Order Status' => $eq->order_status,
                        'Drawing Approval' => $eq->drawing,
                        'Scope' => $eq->scope,
                        'Design Status' => $eq->design,
                        'Material Status' => $eq->material,
                        'Fabrication Status' => $eq->fab,
                        'FAT Status' => $eq->fat,
                        'Start of Manufacturing' => $eq->start,
                        'End of Manufacturing' => $eq->end,
                        'FAT Date' => $eq->fatdate,
                        'Contractual Delivery' => $eq->contractualdate,
                        'Actual Delivery' => $eq->actualdate,
                        'Needed Delivery' => $eq->neededsite,
                        'Open Points' => $eq->openpoints,
                        'Remarks' => $eq->remarks,
                    ];
                }
            }
        }
        $headings = [
            'Work Package No', 'Work Package Name', 'Supplier', 'PO Number', 'Expediting Category', 'Order Date', 'Incoterms', 'Forecast Delivery', 'Workstream/Building',
            'Equipment Name', 'Sub Supplier', 'Quantity', 'Place', 'Order Status', 'Drawing Approval', 'Scope', 'Design Status', 'Material Status', 'Fabrication Status', 'FAT Status', 'Start of Manufacturing', 'End of Manufacturing', 'FAT Date', 'Contractual Delivery', 'Actual Delivery', 'Needed Delivery', 'Open Points', 'Remarks'
        ];
        return \Maatwebsite\Excel\Facades\Excel::download(new class($rows, $headings) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $rows; private $headings;
            public function __construct($rows, $headings) { $this->rows = $rows; $this->headings = $headings; }
            public function array(): array { return $this->rows; }
            public function headings(): array { return $this->headings; }
        }, 'all_workpackages_export.xlsx');
    }
}
