<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;
use DB;


class CustomerController extends Controller
{


	public function index(Request $request){
	
		$like = $request->name;

		
		if($like != ""){

		    $data = DB::table('customers')
	    				->where('customers.name', 'LIKE', "$request->name")
		   			 	->select('customers.*')
		    			->get();
		}else{
			$data = DB::table('customers')
						->simplePaginate(10);
		}
		return response()->json([
					         "status"=>true,
					         "data"=>$data,
						    ]);
 
	}
 


 	public function view(Request $request){

 		$customer_id = $request->customer_id;



 		$data = DB::table('customers')
 				 				->get();

 				
		$orderDetal = DB::table('customers')
		->join('orders','customers.id','orders.customer_Id')
		->where('orders.customer_Id',$customer_id)
		->get();
       





		return response()->json([
				"status"=>true,
				"data"=>['details'=>$data,'orders'=>$orderDetal],
				
			]);
	}


	public function store(Request $request){

		$this->validate($request, [
	     'name' => 'required',
	    'email' => 'required|email',
	    'primary_phone' => 'required|unique:customers'
	   ]);
		
		$customer = new Customer;
		$customer->store_id = $request->store_id;
		$customer->name = $request->name;
		$customer->primary_phone= $request->primary_phone;
		$customer->phone2= $request->phone2;
		$customer->email= $request->email;
		$customer->street= $request->street;
		$customer->city= $request->city;
		$customer->state= $request->state;
		$customer->country= $request->country;
		$customer->pincode= $request->pincode;
		$customer->save();
		return response()->json(["status"=>true,"message"=>"Customer Data Store successfully"]);
	}

	public function update(Request $request){

	
		$this->validate($request, [
	     'name' => 'required',
	    'email' => 'required|email',
	    'primary_phone' => 'required|unique:customers'
	   ]);
		$customer = Customer::find($request->id);
		$customer->store_id = $request->store_id;
		$customer->name = $request->name;
		$customer->primary_phone= $request->primary_phone;
		$customer->phone2= $request->phone2;
		$customer->email= $request->email;
		$customer->street= $request->street;
		$customer->city= $request->city;
		$customer->state= $request->state;
		$customer->country= $request->country;
		$customer->pincode= $request->pincode;
		$customer->update();
		return response()->json(["status"=>true,"message"=>"Customer Data Update successfully"]);
	}




    
    

 }
