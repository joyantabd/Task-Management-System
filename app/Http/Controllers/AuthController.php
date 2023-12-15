<?php

namespace App\Http\Controllers;

use App\Helpers\Log;
use App\Http\Requests\AuthRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public const ADMIN = 1;
    public const MANAGER = 2;

    public function login(AuthRequest $request)
    {

        $admin = User::whereEmail($request->input('email'))->first();
        $member = Member::whereEmail($request->input('email'))->first();


        if ($admin  && Hash::check($request->input('password'), $admin->password)) {
            $branch = null;

            $data = ([
                'token' => $admin->createToken($admin->email)->plainTextToken,
                'id' =>$admin->id,
                'name' => $admin->name,
                'email' =>  $admin->email,
                'phone' => $admin->phone,
                'photo' => $admin->photo,
                'role' => $admin->role_id,
                'branch' => 'Admin'

            ]);
            Log::addToLog("$admin->name has New Login Session");
            return response()->json($data);
        }else if ($member  && Hash::check($request->input('password'), $member->password)) {
            $branch = null;

            $data = ([
                'token' => $member->createToken($member->email)->plainTextToken,
                'id' =>$member->id,
                'name' => $member->name,
                'email' =>  $member->email,
                'phone' => $member->phone,
                'photo' => $member->photo,
                'role' => 2,
                'branch' => 'User'

            ]);
            
            Log::addToLog("$member->name has New Login Session");
            return response()->json($data);
        }


        throw ValidationException::withMessages([
            'email' => ['Email is Invalid']
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['msg' => 'Logged Out']);
    }
}
