<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingForm;

class ExpeditingCardController extends Controller
{
    // Show expediting forms in card layout
    public function index(Request $request)
    {
        $query = \App\Models\ExpeditingContext::query();
        // Only show for supplier: filter by supplier name or company
        if (auth()->user()->role === 'Supplier') {
            // Try to match by company_name or user name (adjust as needed)
            $supplierName = auth()->user()->company_name ?? auth()->user()->name;
            $query->where('supplier', $supplierName);
        }
        // Filters
        if ($request->filled('supplier_name')) {
            $query->where('supplier', 'like', '%' . $request->supplier_name . '%');
        }
        if ($request->filled('expediting_category')) {
            $query->where('expediting_category', $request->expediting_category);
        }
        if ($request->filled('delivered')) {
            if ($request->delivered === 'Yes') {
                $query->where('delivered', 1);
            } elseif ($request->delivered === 'No') {
                $query->where('delivered', 0);
            }
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('workpackage_name', 'like', '%' . $search . '%')
                  ->orWhere('work_package_no', 'like', '%' . $search . '%')
                  ->orWhere('po_number', 'like', '%' . $search . '%');
            });
        }
        $perPage = 20;
        $page = $request->input('page', 1);
        $expeditingContexts = $query->orderByDesc('created_at')->paginate($perPage, ['*'], 'page', $page);
        // Attach supplier email to each context for card display
        foreach ($expeditingContexts as $context) {
            $supplierUser = \App\Models\User::where('role', 'Supplier')->where('name', $context->supplier)->first();
            $context->supplier_email = $supplierUser ? $supplierUser->email : null;
            // Calculate average progress for each status using ExpeditingEquipment for this context_id
            $equipments = \App\Models\ExpeditingEquipment::where('context_id', $context->id)->get();
            $context->avg_design = $equipments->count() ? round($equipments->avg('design')) : 0;
            $context->avg_material = $equipments->count() ? round($equipments->avg('material')) : 0;
            $context->avg_fabrication = $equipments->count() ? round($equipments->avg('fab')) : 0;
            $context->avg_fat = $equipments->count() ? round($equipments->avg('fat')) : 0;
            // Delivered/Total equipment count
            $context->total_equipment = $equipments->count();
            $context->delivered_equipment = $equipments->where('status', 'Delivered')->count();
            // Per-equipment delivered status (true if all checks are true, else false)
            $context->equipment_delivered_status = $equipments->map(function($eq) {
                if (is_array($eq->checks) && count($eq->checks)) {
                    // Consider delivered if all checks are true
                    return collect($eq->checks)->every(fn($v) => $v === true);
                }
                return false;
            })->toArray();
        }
        return view('expediting.cards', ['expeditingForms' => $expeditingContexts]);
    }
}
