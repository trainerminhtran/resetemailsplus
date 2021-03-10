<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 2019-11-15
 * Time: 13:49
 */

namespace App\Helper;


use function GuzzleHttp\Psr7\build_query;

class ServicesApiSamSung
{
    public function __construct()
    {
        $this->servicesHelper = new ServicesHelper();
    }

    public function LoginSamSungHTML(){

      //input SellerID
      $apiUrl = "https://samsung.sumtotal.host/Broker/Account/Login.aspx?wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&ReturnUrl=http%3a%2f%2fsamsung.sumtotal.host%2fBroker%2fToken%2fSaml11.ashx%3fwa%3dwsignin1.0%26wtrealm%3dhttps%253a%252f%252fsamsung.sumtotal.host%252fcore%252f%26wreply%3dhttp%253a%252f%252fsamsung.sumtotal.host%252fCore%252fPublicAccess%252fErrorView%253f__ExCounter%253d1%2526__TicketId%253d0087ddc0-53e5-4eb3-8031-0f55307e6564&domainid=52160A28FC58BBBE7D714E075077AC76";
      $header = $this->getHeader();

      $getResponseHtml = $this->servicesHelper->processRequest($apiUrl, [] , $header, 'html');

      //process HTMl
      return $getResponseHtml;


    }
    public function loginSamSung($params, $cookie){

        $apiUrl = "https://samsung.sumtotal.host/Broker/Account/Login.aspx?wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&ReturnUrl=http%3a%2f%2fsamsung.sumtotal.host%2fBroker%2fToken%2fSaml11.ashx%3fwa%3dwsignin1.0%26wtrealm%3dhttps%253a%252f%252fsamsung.sumtotal.host%252fcore%252f%26wreply%3dhttp%253a%252f%252fsamsung.sumtotal.host%252fcore%252f&IsHybridOrNativeClient=False&domainid=52160A28FC58BBBE7D714E075077AC76";


        $urlEncode = http_build_query($params);
        $length = strlen($urlEncode);
        $header = $this->getHeaderForm($cookie,$length);


        $getResponse =   $this->servicesHelper->processRequest($apiUrl, $urlEncode , $header);

        if ($getResponse["status"]){
            $getResponse["cookies"] =  $cookie. "; ".$getResponse["cookies"];
            //array_push($header, "Cookie:".$getResponse["cookies"] );
            $getResponse["headers"] = $header;

        }

        return $getResponse;


    }

    public function getToken($params, $cookie){

        $apiUrl = "https://samsung.sumtotal.host/Broker/Token/Saml11.ashx?wa=wsignin1.0&wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&wreply=http%3a%2f%2fsamsung.sumtotal.host%2fcore%2f";


        $header = $this->getHeader($cookie);

        $getResponse =   $this->servicesHelper->processRequest($apiUrl, [] , $header , "wresult");

        if ($getResponse["status"]){

            array_push($header, "Cookie:".$getResponse["cookies"] );
            $getResponse["headers"] = $header;
        }

        return $getResponse;


    }

    public function samsungCore($params ,$cookie){

        $apiUrl = "https://samsung.sumtotal.host/core/";

        $urlEncode = http_build_query($params);

        $header = $this->getHeaderForm($cookie);


        $getResponse =   $this->servicesHelper->processRequest($apiUrl, $urlEncode , $header);


        if ($getResponse["status"]){

            //array_push($header, "Cookie:".$getResponse["cookies"] );
            $getResponse["cookies"] =  $cookie. "; ".$getResponse["cookies"];
            $getResponse["headers"] = $header;
        }

        return $getResponse;


    }


    public function testGetSettingsForPreferenceScreen($cookie){

        $apiUrl = "https://samsung.sumtotal.host/Core/Core/api/settingapi/GetSettingsForPreferenceScreen";

        $header = $this->getHeaderFull($cookie);


        $getResponse =   $this->servicesHelper->processRequest($apiUrl, [] , $header);


        if ($getResponse["status"]){
            $getResponse["headers"] = $header;
        }

        return $getResponse;


    }

    public function getAllUser($params , $cookie){

        $apiUrl = "https://samsung.sumtotal.host/Core/Core/api/profiledata/GetAllUser";

        $header = $this->getHeaderFull($cookie);


        $getResponse =   $this->servicesHelper->processRequest($apiUrl, json_encode($params) , $header);


        if (!empty($getResponse["body"])){
            $getResponse["body"] = json_decode($getResponse["body"],true);
        }

        return $getResponse;


    }

    public function editEmailUser($params , $cookie){

        $apiUrl = "https://samsung.sumtotal.host/Core/Core/api/profiledata/EditUser?modelName=personaldetails";

        $header = $this->getHeaderFull($cookie);

        $getResponse =   $this->servicesHelper->processRequest($apiUrl, json_encode($params) , $header , "test");


        if (!empty($getResponse["body"])){
            $getResponse["body"] = json_decode($getResponse["body"],true);
        }

        return $getResponse;


    }

    public function modelConfigurations($userId , $cookie){

        $apiUrl = "https://samsung.sumtotal.host/Core/Core/api/globalconfiguratorapi/modelconfigurations?modelname=personaldetails&targetUserId=".$userId;

        $header = $this->getHeaderFull($cookie);

        $getResponse =   $this->servicesHelper->processRequest($apiUrl, [] , $header);


        if (!empty($getResponse["body"])){
            $getResponse["body"] = json_decode($getResponse["body"],true);
        }

        return $getResponse;


    }

    public function getHeader($cookie = "")
    {
        $header = [
            'Connection: keep-alive',
            'Cache-Control: max-age=0',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',

            'Sec-Fetch-Site: same-origin',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-User: ?1',
            'Sec-Fetch-Dest: document',
            'Referer: https://samsung.sumtotal.host/Broker/Account/Login.aspx?wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&ReturnUrl=http%3a%2f%2fsamsung.sumtotal.host%2fBroker%2fToken%2fSaml11.ashx%3fwa%3dwsignin1.0%26wtrealm%3dhttps%253a%252f%252fsamsung.sumtotal.host%252fcore%252f%26wreply%3dhttp%253a%252f%252fsamsung.sumtotal.host%252fcore%252f&IsHybridOrNativeClient=False&domainid=52160A28FC58BBBE7D714E075077AC76',

        ];
        if(!empty($cookie)){
            array_push($header, 'Cookie:'.$cookie);
        }
        return $header;
    }
    public function getHeaderFull($cookie = "")
    {
        $header = [
            'Accept: application/json, text/plain, */*',
            'Connection: keep-alive',
            'Content-Type: application/json;charset=UTF-8',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36',
            'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
            'Sec-Fetch-Site: same-origin',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Dest: empty',
            'Referer: https://samsung.sumtotal.host/Broker/Account/Login.aspx?wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&ReturnUrl=http%3a%2f%2fsamsung.sumtotal.host%2fBroker%2fToken%2fSaml11.ashx%3fwa%3dwsignin1.0%26wtrealm%3dhttps%253a%252f%252fsamsung.sumtotal.host%252fcore%252f%26wreply%3dhttp%253a%252f%252fsamsung.sumtotal.host%252fcore%252f&IsHybridOrNativeClient=False&domainid=52160A28FC58BBBE7D714E075077AC76',

        ];
        if(!empty($cookie)){
            array_push($header, 'Cookie:'.$cookie);
        }
        return $header;
    }
    public function getHeaderForm($cookie = "" , $length = 0)
    {
        $header = [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control:max-age=0',
            'Connection: keep-alive',
            'Content-Type: application/x-www-form-urlencoded',
            'Host: samsung.sumtotal.host',
            'Origin: https://samsung.sumtotal.host',
            'Referer: https://samsung.sumtotal.host/Broker/Account/Login.aspx?wtrealm=https%3a%2f%2fsamsung.sumtotal.host%2fcore%2f&ReturnUrl=http%3a%2f%2fsamsung.sumtotal.host%2fBroker%2fToken%2fSaml11.ashx%3fwa%3dwsignin1.0%26wtrealm%3dhttps%253a%252f%252fsamsung.sumtotal.host%252fcore%252f%26wreply%3dhttp%253a%252f%252fsamsung.sumtotal.host%252fcore%252f&domainid=52160A28FC58BBBE7D714E075077AC76',
            'Sec-Fetch-Dest: document',
            'Sec-Fetch-Mode: navigate',
            'Sec-Fetch-Site: same-origin',
            'Sec-Fetch-User: ?1',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36',

        ];
        if(!empty($cookie)){
            array_push($header, 'Cookie:'.$cookie);
        }
        if(!empty($length)){
            //array_push($header, 'Content-Length:'.$length);
        }
        return $header;
    }

}
