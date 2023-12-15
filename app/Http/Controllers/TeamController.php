<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeamEditResource;
use App\Manager\ImageManager;
use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = (new Team())->getData($request->all());
        return TeamResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getTeam()
    {
        $data = (new Team())->getDataIdName();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $data = (new Team())->prepareData($request->all());

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Team::IMAGE_UPLOAD_PATH,Team::PHOTO_WIDTH,Team::PHOTO_HEIGHT,
        Team::THUMB_IMAGE_UPLOAD_PATH,Team::PHOTO_THUMB_WIDTH,Team::PHOTO_THUMB_HEIGHT);

        $create = Team::create($data);
        return response()->json(['msg'=>'Inserted Successfully','cls'=>'success']);
        }else{
        return response()->json(['msg'=>'Something Went Wrong','cls'=>'warning','flag'=>'true']);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        return new TeamEditResource($team);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        
        $data = (new Team())->prepareData($request->all());

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Team::IMAGE_UPLOAD_PATH,Team::PHOTO_WIDTH,Team::PHOTO_HEIGHT,
        Team::THUMB_IMAGE_UPLOAD_PATH,Team::PHOTO_THUMB_WIDTH,Team::PHOTO_THUMB_HEIGHT,
        $team->photo_preview);
        }
        $update = $team->update($data);;
        return response()->json(['msg'=>'Updated Successfully','cls'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json(['msg'=>'Deteleted Successfully','cls'=>'warning']);
    }
}
