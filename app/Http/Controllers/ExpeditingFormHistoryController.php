<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpeditingFormHistory;

class ExpeditingFormHistoryController extends Controller
{
    public function index(Request $request)
    {
        $activities = ExpeditingFormHistory::orderByDesc('changed_at')->paginate(20);
        return view('workpackage_activity', compact('activities'));
    }
}
