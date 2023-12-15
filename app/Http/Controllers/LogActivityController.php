<?php

namespace App\Http\Controllers;

use App\Http\Resources\AccessLogResource;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $data = (new AccessLog())->getData($request->all());
        return AccessLogResource::collection($data);
    }
}
