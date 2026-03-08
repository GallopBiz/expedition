<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalendarUpdateController extends Controller
{
    public function deleteMaterial($materialPlanId)
    {
        $materialPlan = \App\Models\MaterialPlan::find($materialPlanId);
        if ($materialPlan) {
            $materialPlan->delete();
            return redirect()->back()->with('success', 'Material plan deleted successfully.');
        }
        return redirect()->back()->with('error', 'Material plan not found.');
    }
    public function deleteInspection($inspectionId)
    {
        $inspection = \App\Models\Inspection::find($inspectionId);
        if ($inspection) {
            $inspection->delete();
            return redirect()->back()->with('success', 'Inspection deleted successfully.');
        }
        return redirect()->back()->with('error', 'Inspection not found.');
    }
    public function show(Request $request)
    {
        $contextId = $request->input('context_id');
        $workPackage = $contextId ? \App\Models\ExpeditingContext::find($contextId) : null;
        $workPackages = \App\Models\ExpeditingContext::all();
        $inspections = $contextId ? \App\Models\Inspection::where('context_id', $contextId)->get() : \App\Models\Inspection::all();
        $materialPlans = $contextId ? \App\Models\MaterialPlan::where('context_id', $contextId)->get() : \App\Models\MaterialPlan::all();
        $fabricationPlans = $contextId ? \App\Models\FabricationPlan::where('context_id', $contextId)->get() : \App\Models\FabricationPlan::all();
        return view('calendar_update', [
            'workPackages' => $workPackages,
            'workPackage' => $workPackage,
            'inspections' => $inspections,
            'materialPlans' => $materialPlans,
            'fabricationPlans' => $fabricationPlans,
            'contextId' => $contextId
        ]);
    }

    public function saveInspection(Request $request)
    {
        $data = $request->only(['inspection_date', 'inspection_for', 'inspection_location']);
        $data['context_id'] = $request->input('context_id');
        $files = [];
        if ($request->hasFile('inspection_file')) {
            foreach ($request->file('inspection_file') as $file) {
                $path = $file->store('calendar/inspection');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'ext' => $file->getClientOriginalExtension(),
                ];
            }
        }
        $data['files'] = $files;
        $data['user_id'] = auth()->id();
        \App\Models\Inspection::create($data);
        return redirect()->back()->with('success', 'Inspection details saved.');
    }

    public function saveMaterial(Request $request)
    {
        $data = $request->only(['contract_date', 'first_handover_date', 'last_date']);
        $data['context_id'] = $request->input('context_id');
        $files = [];
        if ($request->hasFile('material_files')) {
            foreach ($request->file('material_files') as $file) {
                $path = $file->store('calendar/material');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'ext' => $file->getClientOriginalExtension(),
                ];
            }
        }
        $data['files'] = $files;
        $data['user_id'] = auth()->id();
        \App\Models\MaterialPlan::create($data);
        return redirect()->back()->with('success', 'Material planning saved.');
    }

    public function saveFabrication(Request $request)
    {
        $data = $request->only(['fabrication_contract_date', 'fabrication_first_handover_date', 'fabrication_last_update']);
        $data['context_id'] = $request->input('context_id');
        $files = [];
        if ($request->hasFile('fabrication_files')) {
            foreach ($request->file('fabrication_files') as $file) {
                $path = $file->store('calendar/fabrication');
                $files[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'ext' => $file->getClientOriginalExtension(),
                ];
            }
        }
        $data['files'] = $files;
        $data['user_id'] = auth()->id();
        \App\Models\FabricationPlan::create($data);
        return redirect()->back()->with('success', 'Fabrication planning saved.');
    }

    public function editInspection($id)
    {
        $inspection = \App\Models\Inspection::findOrFail($id);
        return view('calendar_update_edit_inspection', [
            'inspection' => $inspection
        ]);
    }

    // Handle AJAX calendar comment save
    public function saveComment(Request $request)
    {
        $contextId = $request->input('context_id');
        $date = $request->input('date');
        $category = $request->input('category');
        $comment = $request->input('comment');

        if ($category === 'Inspection') {
            \App\Models\Inspection::create([
                'context_id' => $contextId,
                'inspection_date' => $date,
                'inspection_for' => $comment,
                'inspection_location' => '',
                'user_id' => auth()->id(),
                'files' => null,
            ]);
        } elseif ($category === 'Material Planning') {
            \App\Models\MaterialPlan::create([
                'context_id' => $contextId,
                'contract_date' => $date,
                'first_handover_date' => $date,
                'last_date' => $date,
                'user_id' => auth()->id(),
                'files' => null,
            ]);
        } elseif ($category === 'Fabrication Planning') {
            \App\Models\FabricationPlan::create([
                'context_id' => $contextId,
                'fabrication_contract_date' => $date,
                'fabrication_first_handover_date' => $date,
                'fabrication_last_update' => $date,
                'user_id' => auth()->id(),
                'files' => null,
            ]);
        }
        return response()->json(['success' => true]);
    }
}
