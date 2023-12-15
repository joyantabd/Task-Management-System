<?php

namespace App\Utility;

use Carbon\Carbon;

class DateFormat{

    public static function CalculaeRemainDate($discount_end) {

        $discount_remain_days = 0;
        if($discount_end !=null){
            $discount_remain_days = Carbon::now()->diffInDays(Carbon::create($discount_end));
        }
        return $discount_remain_days;
        
    }

}