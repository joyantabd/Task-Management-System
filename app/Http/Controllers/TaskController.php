<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskEditResource;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Manager\ImageManager;
use App\Models\TaskAssign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = (new Task())->getData($request->all());
        return TaskResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    public function getTask()
    {
        $data = (new Task())->getDataIdName();
        return response()->json($data); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = (new Task())->prepareData($request->all());

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Task::IMAGE_UPLOAD_PATH,Task::PHOTO_WIDTH,Task::PHOTO_HEIGHT,
        Task::THUMB_IMAGE_UPLOAD_PATH,Task::PHOTO_THUMB_WIDTH,Task::PHOTO_THUMB_HEIGHT);

        $create = Task::create($data);
        return response()->json(['msg'=>'Inserted Successfully','cls'=>'success']);
        }else{
        return response()->json(['msg'=>'Something Went Wrong','cls'=>'warning','flag'=>'true']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskEditResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $data = (new Task())->prepareData($request->all());

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Task::IMAGE_UPLOAD_PATH,Task::PHOTO_WIDTH,Task::PHOTO_HEIGHT,
        Task::THUMB_IMAGE_UPLOAD_PATH,Task::PHOTO_THUMB_WIDTH,Task::PHOTO_THUMB_HEIGHT,
        $task->photo_preview);
        }
        $update = $task->update($data);;
        return response()->json(['msg'=>'Updated Successfully','cls'=>'success']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['msg'=>'Deteleted Successfully','cls'=>'warning']);
    }
}
