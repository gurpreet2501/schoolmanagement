<?php
namespace App\Response;

use \Exception;
use App\Response\Response;


class Factory
{


    /**
     * @param Any $data
     * @return Array
     */
    public static function success($data)
    { 
        return [
            'STATUS'  => "SUCCESS",
            'RESPONSE'    => $data,
            'ERRORS'  => [],
            'NOTICES'  => []
        ];
    }

    /**
     * @param Error Code
     * @return Array
     */
     public static function errorCode($code)
    {   
        $CI = &get_instance();
        return [
            'STATUS'  => 'FAILED',
            'RESPONSE'  => [],
            'ERRORS'  => [
               $code => $CI->config->item('errors')[$code] 
            ],
            'NOTICES'  => []
        ];
    }

 
}
