<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingEquipment;

class ExpeditingEquipmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'expediting_form_id' => 'required|exists:expediting_forms,id',
            'name' => 'required|string|max:255',
            'design' => 'nullable|integer',
            'material' => 'nullable|integer',
            'fab' => 'nullable|integer',
            'fat' => 'nullable|integer',
            'status' => 'nullable|string|max:50',
            'subsupplier' => 'nullable|string|max:255',
            'qty' => 'nullable|integer',
            'place' => 'nullable|string|max:255',
            'order_status' => 'nullable|string|max:255',
            'drawing' => 'nullable|string|max:255',
            'scope' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'duration' => 'nullable|integer',
            'fatdate' => 'nullable|date',
            'contractualdate' => 'nullable|date',
            'actualdate' => 'nullable|date',
            'openpoints' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'checks' => 'nullable|array',
        ]);
        $validated['checks'] = $request->input('checks', []);
        $equipment = ExpeditingEquipment::create($validated);
        return response()->json(['success' => true, 'equipment' => $equipment]);
    }

    public function list(Request $request)
    {
        $formId = $request->input('expediting_form_id');
        if (!$formId) return response()->json([]);
        $equipments = ExpeditingEquipment::where('expediting_form_id', $formId)->get();
        return response()->json($equipments);
    }
}
