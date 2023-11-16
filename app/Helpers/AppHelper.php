<?php

namespace App\Helpers;

class AppHelper
{
    public static function generateOTP(): ?string
    {
        $randomNumber = mt_rand(000000000, 99999999);
        return substr($randomNumber, 0, 6);
    }

    public static function dateInterval($previousTime, $currentTime): string|bool
    {
        if(empty($previousTime)){
            return false;
        }

        $previousTime = new \DateTime($previousTime);
        $currentTime = new \DateTime($currentTime);
        $interval = $previousTime->diff($currentTime);
        $intervalInminutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        return $intervalInminutes;
    }
}
