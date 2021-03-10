<?php
/**
 * Created by PhpStorm.
 * User: macos
 * Date: 2019-11-15
 * Time: 02:11
 */
namespace App\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class ServicesHelper
{

    private $login;
    private $listUserAgent = [
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36",
        "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.83 Safari/537.1",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36",
        "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36",
        "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36",
        "Mozilla/5.0 (Windows NT 5.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1",
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1",
        "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:67.0) Gecko/20100101 Firefox/67.0",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0",
        "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0",
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0"
        ];
    private $host,$origin,$referer,$xsrf,$cookie;

    public function __construct()
    {

    }

    public function buildHeaderSP($cookie = null){

        if ($cookie){
            $this->cookie = "Cookie : ".$cookie;
        }
        return [
            'Accept : application/json, text/plain, */*',
            'Accept-Encoding : gzip, deflate, br',
            'Accept-Language : vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
            'Connection : keep-alive',
            'Content-Type : application/x-www-form-urlencoded; charset=UTF-8',
            'Host : banhang.shopee.vn',
            'Sec-Fetch-Mode : cors',
            'Sec-Fetch-Site : same-origin',
            'User-Agent : ' . $this->listUserAgent[array_rand($this->listUserAgent)],
            $this->cookie

        ];


    }


    public function buildHeaderTK2($xtoken = null , $type = 1 , $cookie = ""){
        return [
            'Accept: application/json',
            'Content-Type: application/json',
            'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
            'Authorization: Bearer '.$xtoken,
            'Connection: keep-alive',
            'Host: sellercenter.tiki.vn',
            'Referer: https://sellercenter.tiki.vn/new/',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',

        ];
    }
    public function buildHeaderLZD2($xtoken = null , $type = 1 , $cookie = ""){

        if ($cookie){
            $this->cookie = "Cookie: ".$cookie;
        }


        if ($type == 1){
            return [
                'Accept: application/json, text/javascript',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Host: sellercenter.lazada.vn',
                'Referer: https://sellercenter.lazada.vn/',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                'X-Requested-With: XMLHttpRequest',
                $this->cookie
            ];
        }else if($type == 2){
            return [
                'Accept: */*',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded',
                'Host: uac.lazada.com',
                'Referer: https://sellercenter.lazada.vn/seller/login?redirect_url=https%3A%2F%2Fsellercenter.lazada.vn%2F',
                'Sec-Fetch-Mode: no-cors',
                'Sec-Fetch-Site: cross-site',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                $this->cookie
            ];
        }else{
            return [
                'Accept: *',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded',
                'Host: sellercenter.lazada.vn',
                'Origin: https://sellercenter.lazada.vn',
                'Referer: https://sellercenter.lazada.vn/seller/login?redirect_url=https%3A%2F%2Fsellercenter.lazada.vn%2F',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                'X-Requested-With: XMLHttpRequest',
                'X-XSRF-TOKEN: '.$xtoken,
                $this->cookie
                //'Cookie: c_csrf=538fc00f-08dd-4027-833f-bcf83215ca04; JSID=154f64af5930892bf758ffba4f945f51; CSRFT=f6747fb3b83b6; TID=286e7811dc0dc55f6ae641100f1d2224; _lang=vi_VN; t_fv=1575558644343; t_uid=k2WilyXU9h5AvuifE1ivt10k2dbe9s9u; t_sid=0TTuR9vOAd9Wv1j3NjnBmhdStTOEKEPB; utm_channel=NA; cna=rZYGFnTJ/mYCAXRqCM8+UvKY; JSESSIONID=node01nk4pjgzknm3m10xiad7kcsvuz4535507.node0'
            ];
        }




    }

    public function buildHeaderShoppe2($type = 1 , $cookie = ""){

        if ($cookie){
            $this->cookie = "Cookie: ".$cookie;
        }


        if ($type == 1){
            return [
                'Accept: application/json, text/plain, */*',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'Host: banhang.shopee.vn',
                'Origin: https://banhang.shopee.vn',
                'Referer: https://banhang.shopee.vn/account/signin',
                'sc-fe-ver: v191216-adhoc',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: ' . $this->listUserAgent[array_rand($this->listUserAgent)],
            ];
        }else if($type == 2){
            return [
                'Accept: */*',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded',
                'Host: uac.lazada.com',
                'Referer: https://sellercenter.lazada.vn/seller/login?redirect_url=https%3A%2F%2Fsellercenter.lazada.vn%2F',
                'Sec-Fetch-Mode: no-cors',
                'Sec-Fetch-Site: cross-site',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                $this->cookie
            ];
        }else{
            return [
                'Accept: *',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded',
                'Host: sellercenter.lazada.vn',
                'Origin: https://sellercenter.lazada.vn',
                'Referer: https://sellercenter.lazada.vn/seller/login?redirect_url=https%3A%2F%2Fsellercenter.lazada.vn%2F',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36',
                'X-Requested-With: XMLHttpRequest',
                $this->cookie
                //'Cookie: c_csrf=538fc00f-08dd-4027-833f-bcf83215ca04; JSID=154f64af5930892bf758ffba4f945f51; CSRFT=f6747fb3b83b6; TID=286e7811dc0dc55f6ae641100f1d2224; _lang=vi_VN; t_fv=1575558644343; t_uid=k2WilyXU9h5AvuifE1ivt10k2dbe9s9u; t_sid=0TTuR9vOAd9Wv1j3NjnBmhdStTOEKEPB; utm_channel=NA; cna=rZYGFnTJ/mYCAXRqCM8+UvKY; JSESSIONID=node01nk4pjgzknm3m10xiad7kcsvuz4535507.node0'
            ];
        }




    }


    public function buildHeader($type = null , $cookie = null){

        if ($type == "shopee"){
            $this->host = "banhang.shopee.vn";
            $this->origin = "https://banhang.shopee.vn";
            $this->referer = "https://banhang.shopee.vn/account/signin";

        }else if($type == "lzd"){

            return [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                'Cache-Control: max-age=0',
                'Connection: keep-alive',
                'Host: sellercenter.lazada.vn',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Site: none',
                'Sec-Fetch-User: ?1',
                'Upgrade-Insecure-Requests: 1',
                'User-Agent: ' . $this->listUserAgent[array_rand($this->listUserAgent)],
            ];

        }else if($type == "sd"){
            if ($cookie){
                $this->cookie = "Authorization: ". $cookie;
            }
            return [
                'Host: seller-api.sendo.vn',
                'Content-Type: application/json;charset=utf-8',
                'User-Agent: Sendo%20B%C3%A1n/1 CFNetwork/1107.1 Darwin/19.0.0',
                'Connection: keep-alive',
                'Accept: application/json;profile="mobileseller"',
                'Accept-Language: en-VN;q=1.0, vi-VN;q=0.9',
                //'Accept-Encoding: gzip;q=1.0, compress;q=0.5',
                'Cache-Control: no-cache',
                'Accept-Language: vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
                $this->cookie
            ];
            /*
             * 'Authorization:',
                $this->cookie
             */
        }else if($type == "tiki"){
            return [
                'Accept: application/json',
                'Host: sellercenter.tiki.vn',
                'Origin: https://sellercenter.tiki.vn',
                'Referer: https://sellercenter.tiki.vn/new/',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36'
            ];
        }
        if ($cookie){
            $this->cookie = "Cookie : ".$cookie;
        }
        return [
            'Accept : application/json, text/plain, */*',
            'Accept-Encoding : gzip, deflate, br',
            'Accept-Language : vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7',
            'Connection : keep-alive',
            'Content-Type : application/x-www-form-urlencoded; charset=UTF-8',
            'Host : '.$this->host,
            'Origin : '.$this->origin,
            'Referer : '.$this->referer,
            'Sec-Fetch-Mode : cors',
            'Sec-Fetch-Site : same-origin',
            'User-Agent : ' . $this->listUserAgent[array_rand($this->listUserAgent)],
            $this->cookie

        ];


    }

    public function curlRequest($url, $params = [], $header = [] )
    {

        curl_setopt($this->login, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->login, CURLOPT_RETURNTRANSFER, TRUE);
        //curl_setopt($this->login, CURLOPT_AUTOREFERER, true);
        if ($header){

            curl_setopt($this->login, CURLOPT_HEADER, TRUE);
            curl_setopt($this->login, CURLOPT_HTTPHEADER, $header);
            curl_setopt($this->login, CURLINFO_HEADER_OUT, true);
        }
        if($params){
            //if sendo hash : json_encode($params)
            //else http_build_query($params)

            //curl_setopt($this->login, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($this->login, CURLOPT_POST, true);
            curl_setopt($this->login, CURLOPT_POSTFIELDS, $params);
        }
        //curl_setopt($this->login, CURLOPT_ENCODING, "");
        //curl_setopt($this->login, CURLOPT_MAXREDIRS, 3);
        //curl_setopt($this->login, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        //curl_setopt($this->login, CURLOPT_FRESH_CONNECT, true);


        curl_setopt($this->login, CURLOPT_VERBOSE , true);
        curl_setopt($this->login, CURLOPT_URL, $url);
        curl_setopt($this->login, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //disable ssl
        //curl_setopt($this->login, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($this->login, CURLOPT_SSL_VERIFYPEER, 0);


        curl_setopt($this->login, CURLOPT_FOLLOWLOCATION, TRUE);
        //curl_setopt($this->login, CURLOPT_AUTOREFERER, TRUE);

        ob_start();      // prevent any output
        return curl_exec($this->login); // execute the curl command
        ob_end_clean();  // stop preventing output


    }

    public function processRequest($url , $params = [] , $header = [], $brand = ''){

        try {
            $this->login = curl_init();
            $response = $this->curlRequest($url , $params , $header);



            /*
            if(!empty($brand) && $brand =="test"){

                echo "<pre>";
                echo "URL " . $url . "\n";
                echo "PARAMS: \n ";
                print_r($params);
                echo "\n";
                print_r($header);
                echo "\n";
                print_r($response);
                die;
            }
            */


            if(curl_errno($this->login)){
                return array(
                    'status' => false,
                    'message' => curl_error($this->login)
                );
            }

            $header_size = curl_getinfo($this->login, CURLINFO_HEADER_SIZE);


            $headerResponse = substr($response, 0, $header_size);
            $body = substr($response, $header_size);

            if ($brand === 'html') {
               $body = $this->getDataHTML(substr($response, $header_size));
            } else if( $brand == 'wresult'){
                $body = $this->getWresult(substr($response, $header_size));
            } else {
               $body = substr($response, $header_size);
            }

            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headerResponse, $matches);
            $cookies = array();

            $c_csrf = "";
            foreach($matches[1] as $item) {
                parse_str($item, $cookie);
                $getKey  = key($cookie);
                if(!empty($cookie[$getKey])){
                    $cookies[$getKey]  = $getKey . "=". $cookie[$getKey];
                }
                //$cookies[$getKey]  = $getKey . "=".urlencode($cookie[$getKey]);


                if($getKey == "c_csrf"){
                    $c_csrf = urlencode($cookie[$getKey]);
                }
            }

            $cookies_str = implode("; ",$cookies);

            //stop and close
            curl_close($this->login);
            unset($this->login);


            return array(
              "status"=>true,
              "body" => $body,
              "cookies" => $cookies_str,
              "c_csrf" => $c_csrf
            );
        }catch (\Exception $e){
            return
                array(
                    'status' => false,
                    'message' => $e->getMessage()
                );
            //return $this->responseBadRequest(['message' => $e->getMessage()]);
        }
    }
    private function getDataHTML($string)
    {
        $dataResponse = array();
        $variable = trim(strstr($string, 'VIEWSTATE" value="'));

        $dataResponse["view_state"] = substr($variable, 18, strpos($variable, '" />') - 18);


        $variable = trim(strstr($string, 'EVENTVALIDATION" value="'));

        $dataResponse["event_validation"] = substr($variable, 24, strpos($variable, '" />') - 24);


        return $dataResponse;
    }
    private function getWresult($string){
        $variable = trim(strstr($string, 'wresult" value="'));

        $getToken = substr($variable, 16, strpos($variable, '" />') - 16);

        return  html_entity_decode($getToken);
    }

}
