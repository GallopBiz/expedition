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
        // (Optional) Add filters here if needed, similar to expeditingList
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
