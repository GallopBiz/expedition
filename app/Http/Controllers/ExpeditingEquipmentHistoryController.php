<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingEquipmentHistory;

class ExpeditingEquipmentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $activities = ExpeditingEquipmentHistory::orderByDesc('changed_at')->paginate(20);
        return view('equipment_activity', compact('activities'));
    }
}
