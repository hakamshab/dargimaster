<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth,DB;



class DashboardController extends Controller
{
    public function view(Request $request){

    	$storeid = $request->storeid;

    	$totalorder = DB::table('orders')
    			->where('orders.store_id',$storeid)
    			->count();

		$activeorder = DB::table('orders')
		->where('orders.store_id',$storeid)
		->where('orders.active','true')
		->count();


		$customers = DB::table('customers')
					->where('customers.store_id',$storeid)
					->count();

		$compliteorder = DB::table('orders')
		->where('orders.store_id',$storeid)
		->where('orders.status','complited')
		->count();

		$totelearn = DB::table('orders')
		->where('orders.store_id',$storeid)
		->where('orders.status','complited')
		->sum('total_amount');

		$paidamount = DB::table('orders')
		->where('orders.store_id',$storeid)
		->where('orders.status','complited')
		->sum('advance');

		$pendingamount = $totelearn-$paidamount;

		$store = DB::table('store')
		->where('store.id',$storeid)
		->get();

		$empolyeeprofile = DB::table('employees')
		->where('employees.store_id',$storeid)
		->get();

		$customerlist = DB::table('customers')
		->where('customers.store_id',$storeid)
		->get();

		$orderlistlist = DB::table('orders')
		->where('orders.store_id',$storeid)
		->get();


		   return response()->json([
                             "status"=>true,
                             "result"=>['totalorder'=>$totalorder,'activeorder'=>$activeorder,
                             			'customers'=>$customers,'compliteorder'=>$compliteorder,
                             			'totelearn'=>$totelearn,'paidamount'=>$paidamount,'pendingamount'=>$pendingamount,'store'=>$store,'empolyeeprofile'=>$empolyeeprofile[0]
                             			,'customerlist'=>$customerlist,'orderlistlist'=>$orderlistlist
                                       ],
                            ]);












    }
}
