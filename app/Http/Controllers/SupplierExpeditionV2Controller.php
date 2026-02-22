<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierExpeditionV2Controller extends Controller
{
    public function show()
    {
        // You can pass any required data here
        return view('expediting_forms.supplier_access_v2');
    }
}
