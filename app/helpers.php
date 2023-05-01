<?php
namespace App;
use DB;
class helpers 
{

public static function validaLogin($user_id){

        $getId =$user_id;

        $all_header = getallheaders();
        $Authorization = $all_header['Authorization'] ??  '';

        $result = substr(strstr($Authorization," "), 1);
        // dd($result);
        $jwt_token = $result;
        $allDataCheck = DB::table('employees')
                        ->where('id',$getId)
                        ->where('jwt_token',$jwt_token)
                        ->select('jwt_token')
                        ->first();

            if(!empty($allDataCheck)){
                // return true;
                }
                else
                { 
                    $rersult['status']='0';
                    $rersult['message']='invalid token';
                    echo json_encode($rersult);exit;
                }

            }
            }

?>