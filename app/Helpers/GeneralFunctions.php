<?php

namespace App\Helpers;

class GeneralFunctions
{
    public function curlDate()
    {
        date_default_timezone_set("Africa/Nairobi");
        return date('Y-m-d H:i:s');
    }
}
