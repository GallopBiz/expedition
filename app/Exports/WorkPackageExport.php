<?php
namespace App\Exports;

use App\Models\ExpeditingContext;
use App\Models\ExpeditingEquipment;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkPackageExport implements FromArray, WithHeadings
{
    protected $context;
    protected $equipments;

    public function __construct(ExpeditingContext $context, $equipments)
    {
        $this->context = $context;
        $this->equipments = $equipments;
    }

    public function array(): array
    {
        $rows = [];
        foreach ($this->equipments as $eq) {
            $rows[] = [
                // Context fields
                'Work Package No' => $this->context->work_package_no,
                'Work Package Name' => $this->context->workpackage_name,
                'Supplier' => $this->context->supplier,
                'PO Number' => $this->context->po_number,
                'Expediting Category' => $this->context->expediting_category,
                'Order Date' => $this->context->order_date,
                'Incoterms' => $this->context->incoterms,
                'Forecast Delivery' => $this->context->forecast_delivery_to_site,
                'Workstream/Building' => $this->context->workstream_building,
                // Equipment fields
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
        return $rows;
    }

    public function headings(): array
    {
        return [
            // Context fields
            'Work Package No', 'Work Package Name', 'Supplier', 'PO Number', 'Expediting Category', 'Order Date', 'Incoterms', 'Forecast Delivery', 'Workstream/Building',
            // Equipment fields
            'Equipment Name', 'Sub Supplier', 'Quantity', 'Place', 'Order Status', 'Drawing Approval', 'Scope', 'Design Status', 'Material Status', 'Fabrication Status', 'FAT Status', 'Start of Manufacturing', 'End of Manufacturing', 'FAT Date', 'Contractual Delivery', 'Actual Delivery', 'Needed Delivery', 'Open Points', 'Remarks'
        ];
    }
}
