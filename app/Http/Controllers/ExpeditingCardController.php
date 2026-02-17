<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingForm;

class ExpeditingCardController extends Controller
{
    // Show expediting forms in card layout
    public function index(Request $request)
    {
        $query = ExpeditingForm::query();
        // Filters
        if ($request->filled('supplier_name')) {
            $query->where('supplier', 'like', '%' . $request->supplier_name . '%');
        }
        if ($request->filled('expediting_category')) {
            $query->where('expediting_category', $request->expediting_category);
        }
        if ($request->filled('delivered')) {
            if ($request->delivered === 'Yes') {
                $query->where('delivered', true);
            } elseif ($request->delivered === 'No') {
                $query->where('delivered', false);
            }
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('workpackage_name', 'like', '%' . $search . '%')
                  ->orWhere('work_package_name', 'like', '%' . $search . '%')
                  ->orWhere('work_package', 'like', '%' . $search . '%')
                  ->orWhere('work_package_number', 'like', '%' . $search . '%')
                  ->orWhere('equipment_type_tag_number', 'like', '%' . $search . '%');
            });
        }
        $perPage = 20;
        $page = $request->input('page', 1);
        $expeditingForms = $query->orderByDesc('created_at')->paginate($perPage, ['*'], 'page', $page);
        // Attach supplier email to each form for card display
        foreach ($expeditingForms as $form) {
            $supplierUser = \App\Models\User::where('role', 'Supplier')->where('name', $form->supplier)->first();
            $form->supplier_email = $supplierUser ? $supplierUser->email : null;
        }
        return view('expediting.cards', compact('expeditingForms'));
    }
}
