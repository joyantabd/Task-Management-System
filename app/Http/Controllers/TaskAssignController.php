<?php

namespace App\Http\Controllers;

use App\Helpers\Log;
use App\Http\Resources\TaskAssignEditResource;
use App\Http\Resources\TaskAssignResource;
use App\Http\Resources\TaskEditResource;
use App\Http\Resources\UserAssignTaskResource;
use App\Manager\FileManager;
use App\Models\TaskAssign;
use App\Http\Requests\StoreTaskAssignRequest;
use App\Http\Requests\UpdateTaskAssignRequest;
use App\Models\Member;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = (new TaskAssign())->getData($request->all());
        return TaskAssignResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function taskdone($id)
    {
        $data = ['status'=>2];
        TaskAssign::whereId($id)->update($data);
        return response()->json(['msg'=>'Sent For Approval','cls'=>'success']);
    }

    public function tasklist(Request $request)
    {
        $auth_id = Auth::user()->id;
        $data = (new TaskAssign())->getDataId($request->all(),$auth_id);
        return UserAssignTaskResource::collection($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskAssignRequest $request)
    {
        $data = (new TaskAssign())->prepareData($request->all());

        $create = TaskAssign::create($data);
        $member_name  = Member::whereId($request->input('member_id'))->pluck('name')->first();
        $task_name  = Task::whereId($request->input('task_id'))->pluck('name')->first();
        Log::addToLog("$task_name has been assigned to  $member_name");
        return response()->json(['msg'=>'Inserted Successfully','cls'=>'success']);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskAssign $taskAssign)
    {
        return new TaskAssignEditResource($taskAssign);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskAssign $taskAssign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskAssignRequest $request, TaskAssign $taskAssign)
    {
        $data = (new TaskAssign())->prepareData($request->all());

        $update = $taskAssign->update($data);
        return response()->json(['msg'=>'Updated Successfully','cls'=>'success']);
    }


    public function destroy(TaskAssign $taskAssign)
    {
        $taskAssign->delete();
        return response()->json(['msg'=>'Deteleted Successfully','cls'=>'warning']);
    }
}
