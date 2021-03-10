<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 2020-10-02
 * Time: 11:52
 */

namespace App\Http\Controllers\SystemAPI;

include app_path() . '/SDK/Lazada/LazopSdk.php';
include app_path() . '/SDK/Sendo/SenopSdk.php';

class Setting
{

    private $type = "";
    public function __construct($type)
    {
        $this->type = $type;
    }
    public function instance(){
        if($this->type == "lazada"){

            $accessToken = '50000400918s8fs7jFtaMvDC3lxHjP1d884f11fWPDdEeugnxVgHiRhWkWaoZdA';
            $c = new \LazopClient('https://api.lazada.vn/rest', '120671', 'yo92RAq9HBT6MRke6hEUrJ93BVouLstJ');
            return $c;
        }else if ($this->type == "sendo"){

        }
    }
}
