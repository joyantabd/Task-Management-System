<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Manager\ReportManager;
use App\Models\Member;
use App\Models\TaskAssign;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$id)
    {
        $user_id = $id;
        $assigned = TaskAssign::where('member_id',$user_id)->count();
        $total_team = Team::all()->count();
        $total_member = Member::all()->count();
        $pending_task = TaskAssign::where('status',2)->count();
        $yet_active = TaskAssign::where('status',1)->count();
        $reports = [
            'assign_report' => $assigned ? $assigned : 0,
            'total_team' => $total_team ? $total_team :0,
            'total_member' => $total_member ? $total_member :0,
            'pending_task' => $pending_task ? $pending_task :0,
            'yet_active' => $yet_active ? $yet_active :0,

        ];
        return response()->json($reports);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
