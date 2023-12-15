<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberEditResource;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Manager\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = (new Member())->getData($request->all());
        return MemberResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getTeamMember($id)
    {
        $data = (new Member())->getMemberByTeamId($id);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $data = (new Member())->prepareData($request->all());
        $data['password'] = Hash::make($request['password']); 

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Member::IMAGE_UPLOAD_PATH,Member::PHOTO_WIDTH,Member::PHOTO_HEIGHT,
        Member::THUMB_IMAGE_UPLOAD_PATH,Member::PHOTO_THUMB_WIDTH,Member::PHOTO_THUMB_HEIGHT);
        }
        $create = Member::create($data);
        return response()->json(['msg'=>'Inserted Successfully','cls'=>'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return new MemberEditResource($member);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $data = (new Member())->prepareData($request->all());

        if($request->has('photo'))
        {
        $name = Str::slug($data['name']);
        $file = $request->input('photo');
        $data['photo'] = ImageManager::processImageUpload($file,$name,
        Member::IMAGE_UPLOAD_PATH,Member::PHOTO_WIDTH,Member::PHOTO_HEIGHT,
        Member::THUMB_IMAGE_UPLOAD_PATH,Member::PHOTO_THUMB_WIDTH,Member::PHOTO_THUMB_HEIGHT,
        $member->photo);
        }
        $update = $member->update($data);;
        return response()->json(['msg'=>'Updated Successfully','cls'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json(['msg'=>'Deteleted Successfully','cls'=>'warning']);
    }
}
