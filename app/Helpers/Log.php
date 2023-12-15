<?php


namespace App\Helpers;
use Request;
use App\Models\AccessLog as LogModel;
use Jenssegers\Agent\Agent;

class Log
{


    public static function addToLog($subject)
    {
		// Browser & Platform Detect
		$agent = new Agent();
		$browser = $agent->browser();
		$Bversion = $agent->version($browser);
		$platform = $agent->platform();
        $version = $agent->version($platform);
		$all = $browser.'/'.$Bversion .' ('.$platform.$version.')';
		// Browser & Platform Detect

    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = $all;
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
    	LogModel::create($log);
    }


    public static function ActivityLists()
    {
    	return LogModel::latest()->get();
    }


}
