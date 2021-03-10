<?php
/**
 * File AuthController.php
 *
 * @author Nguyen Hien <nguyen.van.hien.cdtin@gmail.com>
 * @package Laravue
 * @version 1.0
 */
namespace App\Http\Controllers;

use App\Helper\ServicesApiSamSung;
use App\Laravue\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Validator;
/**
 * Class AuthController
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportTotal(Request $request){

        $params = $request->all();
        $getData = array();
        if(isset($params["filter"]) && !empty($params["selecteddate"])){
            $dateFrom = date('Y-m-d 00:00:00', strtotime($params["selecteddate"][0]));
            $dateTo = date('Y-m-d 23:59:59', strtotime($params["selecteddate"][1]));

            $getData = DB::select("EXEC prc_ActionLog_Get @StartTime='".$dateFrom."' , @EndTime='".$dateTo."'");
        }else{
            $getData = DB::select("EXEC prc_ActionLog_Count");

        }


        if($getData){
            return new JsonResponse($getData, "Cập nhật thông tin thành công.");
        }
        return new JsonResponse($getData, "Lấy thông tin không thành công");

    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            array_merge(
                [
                    'email' => ['required'],
                    'password' => ['required'],
                ]
            )
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $params = $request->all();

            $api = new ServicesApiSamSung();
            $responseSamSung = $api->LoginSamSungHTML();



            if(!empty($responseSamSung["body"])){

                $cookie = $responseSamSung["cookies"];
                $getData = $responseSamSung["body"];


                //$cookie = "SumTotalSession=samsung.sumtotal.host=8fa2dcb4410a4f7ca08d05e87067634b;NSC_JOkxga2zencfdtoeespdx0ekrqnkrb0=0045a3d2574e63b0068b9061a673daa1fb367e0a95a26d96dd1dd7f0c509b48038fb874d";
                $paramsLogin = array(
                    "__VIEWSTATE" => $getData["view_state"],
                    "__VIEWSTATEGENERATOR" => "D6B05CC4",
                    "__EVENTVALIDATION" => $getData["event_validation"],
                    'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$UserName'=> "da.admin.vietnam",
                    'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$Password' => "samsung",
                    'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$Languages' => "",
                    'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$LoginButton' =>'Đăng nhập'
                );

                $getResponseLogin = $api->loginSamSung($paramsLogin , $cookie);


                if($getResponseLogin){
                    //getToken
                    $cookieLogin = $getResponseLogin["cookies"];
                    $getToken = $api->getToken(array() , $cookieLogin);

                    if(!empty($getToken["body"])){
                        $getTokenWreply = $getToken["body"];

                        $paramsWreply = array(
                            "wa" => "wsignin1.0",
                            "wresult" => $getTokenWreply,
                            "wreply" => "https://samsung.sumtotal.host/core/"
                        );
                        $getCore = $api->samsungCore($paramsWreply , $cookieLogin);

                        if(!empty($getCore["body"])){
                            $cookieFull = $getCore["cookies"];

                            $paramCheckUser = array(
                                "PageNo" => 1,
                                "PageSize" => 10,
                                "SearchString" => "",
                                "orderBy" => "+FirstName",
                                "Locked" => null,
                                "PendingApp" => false,
                                "Enabled" => null,
                                "Disabled" => null,
                                "Active" => true,
                                "Inactive" => null,
                                "Suspended" => null,
                                "EmployeeTypeid" => array(),
                                "FirstName" => null,
                                "LastName" => null,
                                "EmployeeID" =>null,
                                "Email" => null,
                                "Manager" => null,
                                "Job" => null,
                                "Organization" => null,
                                "LoginUserName" => $params["password"],
                                "ExportOption" => "All",
                                "RequestedPageName" => "AllUser",
                                "GuestAccount" => null,
                                "FilterByGAR" =>true,
                                "CalledFromPage" => "allusers",
                                "CanViewPrivateData" => true
                            );
                            $checkUser = $api->getAllUser($paramCheckUser , $cookieFull);

                            if(!empty($checkUser["body"]["UserList"])){
                                $getUserList = $checkUser["body"]["UserList"][0];

                                if(!empty($getUserList)){
                                    $userId = $getUserList["MaskedPersonNumber"];
                                   $getModelConfig = $api->modelConfigurations($userId , $cookieFull);

                                   if (!empty($getModelConfig["body"])){
                                       //user oke
                                       $forFields = $getModelConfig["body"]["Fields"];



                                       $arrayPersion = array();

                                       $arrayPersion["PersonPK"] = intval($getUserList["PersonPK"]);
                                       $arrayPersion["PersonDomain"] = array(
                                           0 => array(
                                               "PersonFK" => intval($getUserList["PersonPK"]),
                                               "IsPrimary" => true,
                                               "Deleted" => 0,
                                           )
                                       );
                                       $arrayPersion["PersonMobileUser"] = array(
                                           "Usr_PasswordHashType" => null,
                                           "EmpFK" => intval($getUserList["PersonPK"]),
                                       );

                                       if($forFields){
                                           foreach ($forFields as $k=>$v){

                                               if($v["FieldGroup"] == "Person"){
                                                   if($v["FieldName"] == "Person.Active"){
                                                       $arrayPersion["Active"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "Person.StatusCode"){
                                                       $arrayPersion["StatusCode"] = empty($v["FieldDefaultValue"]) ? null :$v["FieldDefaultValue"] ;
                                                   }
                                                   else if($v["FieldName"] == "Person.FirstName"){
                                                       $arrayPersion["FirstName"] = $v["FieldDefaultValue"];
                                                   }
                                                   else if($v["FieldName"] == "Person.StartDate"){
                                                       $date=date_create($v["FieldDefaultValue"]);
                                                       $arrayPersion["StartDate"] = date_format($date,"Y-n-d");
                                                   }
                                                   else if($v["FieldName"] == "Person.LocaleFK"){
                                                       $arrayPersion["LocaleFK"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "Person.LastName"){
                                                       $arrayPersion["LastName"] = $v["FieldDefaultValue"];
                                                   }
                                                   else if($v["FieldName"] == "Person.TimeZoneFK"){
                                                       $arrayPersion["TimeZoneFK"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "Person.FullName"){
                                                       $arrayPersion["FullName"] = $v["FieldDefaultValue"];
                                                   }
                                                   else if($v["FieldName"] == "Person.PersonNumber"){
                                                       $arrayPersion["PersonNumber"] =  $v["FieldDefaultValue"];
                                                   }
                                                   else if($v["FieldName"] == "Person.PublishCalendar"){
                                                       $arrayPersion["PublishCalendar"] = intval($v["FieldDefaultValue"]);
                                                   }
                                               }else if($v["FieldGroup"] == "UserLogin"){
                                                   if($v["FieldName"] == "UserLogin.UserName"){
                                                       $arrayPersion["UserLogin"]["UserName"] = $v["FieldDefaultValue"];
                                                   }
                                                   else if($v["FieldName"] == "UserLogin.MustChangePwd"){
                                                       $arrayPersion["UserLogin"]["MustChangePwd"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "UserLogin.UserEnabled"){
                                                       $arrayPersion["UserLogin"]["UserEnabled"] = intval($v["FieldDefaultValue"]);
                                                   }

                                               }else if($v["FieldGroup"] == "PersonELM"){
                                                   if($v["FieldName"] == "PersonELM.AllowWS"){
                                                       $arrayPersion["PersonELM"]["AllowWS"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "PersonELM.ViewAllEmpsInd"){
                                                       $arrayPersion["PersonELM"]["ViewAllEmpsInd"] = intval($v["FieldDefaultValue"]);
                                                   }

                                               }else if($v["FieldGroup"] == "Person Business Address"){
                                                   if($v["FieldName"] == "PersonCommunication_0.EmailFormat"){
                                                       $arrayPersion["PersonCommunication"][0]["EmailFormat"] = intval($v["FieldDefaultValue"]);
                                                   }
                                                   else if($v["FieldName"] == "PersonCommunication_0.Email1"){
                                                       //$arrayPersion["PersonCommunication"]["Email1"] = $v["FieldDefaultValue"];
                                                       $arrayPersion["PersonCommunication"][0]["Email1"] = $params["email"];
                                                       $arrayPersion["PersonCommunication"][0]["CommunicationType"] = 0;
                                                       $arrayPersion["PersonCommunication"][0]["IsPrimary"] = 1;
                                                   }

                                               }else if($v["FieldGroup"] == "PersonDomain"){
                                                   if($v["FieldName"] == "PersonDomain.RoleFK"){
                                                       $arrayPersion["PersonDomain"][0]["RoleFK"] = intval($v["FieldDefaultValue"]);
                                                       $arrayPersion["UserLogin"]["CurrentRoleFK"] = intval($v["FieldDefaultValue"]);
                                                   }

                                               }else if($v["FieldGroup"] == "Mobile User"){
                                                   if($v["FieldName"] == "Tbl_mobile_user.IsMobileEnabled"){
                                                       $arrayPersion["PersonMobileUser"]["IsMobileEnabled"] = intval($v["FieldDefaultValue"]);
                                                   }

                                               }
                                           }
                                       }

                                       $arrayPersion["PersonIntegration"] = array();

                                       $paramsUpdate = array(
                                           "JsonToPost" => json_encode(array(
                                               "Person" => $arrayPersion
                                           ))
                                       );


                                       $updateEmail = $api->editEmailUser($paramsUpdate , $cookieFull);

                                       if(!empty($updateEmail["body"])){
                                           //success
                                           DB::select("EXEC prc_ActionLog_Save @UserName= '".$params["password"] . "', @Email = '".$params["email"] . "', @Status = 1");
                                           $reponseData = $updateEmail["body"];
                                           return new JsonResponse(array("link"=> "https://tinyurl.com/resetsplus"), "Cập nhật thông tin thành công. \n Click vào link bên dưới để đổi mội khảu: \n https://tinyurl.com/resetsplus");
                                       }else{
                                           return new JsonResponse([], "Cập nhật không thành công");
                                       }

                                   }else{
                                       // permission
                                       return new JsonResponse([], "Cập nhật không thành công");
                                   }
                                }

                            }else{
                                //response User fails

                            }
                        }

                    }

                }

            }
        }

        return new JsonResponse([], "Nhân viên này chưa tồn tại. Vui lòng liên hệ số Hotline: 0777 617 647 để được hướng dẫn tạo mới");

        echo "gg";die;
        $api = new ServicesApiSamSung();
        $responseSamSung = $api->LoginSamSungHTML();
        echo "<pre>";
        echo "gg\n";

        if(!empty($responseSamSung["body"])){
            $getData = $responseSamSung["body"];
            $paramsLogin = array(
                "__VIEWSTATE" => $getData["view_state"],
                "__VIEWSTATEGENERATOR" => "D6B05CC4",
                "__EVENTVALIDATION" =>  $getData["event_validation"],
                'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$UserName' =>$params["email"],
                'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$Password' => $params["password"],
                'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$Languages' => null,
                'ctl00$ctl00$ctl00$BodyContent$MainContent$MainContentPlaceHolder$LoginButton' => "Sign In"
            );

            $api->loginSamSung($paramsLogin);
        }

        print_r($responseSamSung);die;
    }

    public function logout()
    {
        echo "ff";die;

        $api = new ServicesApiSamSung();
        $responseSamSung = $api->LoginSamSungHTML();
        echo "<pre>";
        echo "gg\n";
        print_r($responseSamSung);die;
        $this->guard()->logout();
        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }

    public function user()
    {
        return new UserResource(Auth::user());
    }

    /**
     * @return mixed
     */
    private function guard()
    {
        return Auth::guard();
    }
}
