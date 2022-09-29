<?php

namespace App\Conf;

class Config
{
    //Online Towing status codes
    const SUCCESSFULLY_PROCESSED_REQUEST = 1000;
    const INVALID_AUTHENTICATION_CREDENTIALS =1001;
    const INVALID_PAYLOAD = 1002;
    const GENERIC_EXCEPTION_CODE= 1003;
    const RECORD_NOT_FOUND_CODE= 1004;
    const RECORD_ALREADY_PROCESSED= 1005;
    const GENERIC_EXCEPTION_MESSAGE= "The service is currently unavailable, try again later";
}
