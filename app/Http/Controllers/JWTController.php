<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use App\helpers;
use \stdClass;
use Illuminate\Support\Facades\Auth;


use DB;

class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:api', ['except' => ['login', 'register','profile']]);
    }


 



    public function login(Request $request)
    {

        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|email',
        //     'password' => 'required|string|min:6',
        // ]);
        
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        // if (!$token = auth()->attempt($validator->validated())) {
        //     return response()->json(['error' => 'invalid credentials'], 401);
        // }





        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'name' => ['required'],
        ]);

        $employee = DB::table('employees')
                    ->where('email', $credentials['email'])
                    ->first();

                    $employeetest = DB::table('employees')
                    ->where('name', $credentials['name'])
                    ->first();

                    if(is_null($employeetest)){
                        return response()->json(['error' => 'invalid name'], 401);
                    }


                    // return $employeetest;exit;

                 if (!$employee || !Hash::check($credentials['password'], $employee->password) || !$credentials['name'] == $employeetest->name) {
                     return response()->json(['error' => 'invalid credentials'], 401);
                           }

        $token =Str::random(150);
        // return "hi";
       $allDataGet = DB::table('employees')->where('email',$request->email)->get();
       $getId = $allDataGet[0]->id;
       $jwtTokenUpdate = DB::table('employees')->where('id',$getId)->update(['jwt_token' => $token]);

       $data = DB::table('employees')->where('id',$getId)->get();

       $authId =  $data[0]->id;

       $storeData = DB::table('employees')
                    ->join('store','employees.id','store.emp_id')
                    ->where('store.status',1)
                    // ->where('employees.status',1)
                    ->select('employees.*','store.*')
                    ->get();

        // $data = new stdClass();
        // foreach ($storeData as $key => $value) {
        //    $data->$key = $value;
        // }
        // return $data;
       return response()->json([

                    'status'=> true,
                     'message'=>'login successfully',
                     // 'data'=>$data,
                     'data'=>$storeData

             ]);
        // return $this->respondWithToken($token,$allDataGet);
    }





    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }



         // public function profile(Request $request)
         //    {
         //        $this->validaLogin($request->user_id);

         //        return response()->json(['message' => 'User successfully logged out.']);
         //    }


    

    public function validaLogin($user_id){

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
    protected function respondWithToken($token,$allDataGet)
    {
    	// return $allDataGet[0]->id;
       return response()->json([
        // 'data'=>$allDataGet,
        'jwt_token' => $token,
        'token_type' => 'bearer',
        // 'expires_in' => auth()->factory()->getTTL() * 60
        'expires_in' => auth('api')->factory()->getTTL() * 60
    ]);
    }
   
}