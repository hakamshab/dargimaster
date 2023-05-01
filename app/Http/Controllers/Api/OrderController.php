<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth,DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
    {
        $like = $request->name;
        if($like != ""){

            $data = DB::table('orders')
                        // ->where('orders.name', 'LIKE', "$request->name")
                        // ->join('store','customers.store_id','store.id')
                        ->select('orders.*')
                         ->get();

        }else{

            $data = DB::table('orders')
                // ->join('store','orders.store_id','store.id')
                ->select('orders.*')
                ->paginate(10);
        }
        return response()->json([
                             "status"=>true,
                             "data"=>$data,
                            ]);
    }
    public function store(Request $request)
    {


       //  $this->validate($request, [
       //  'name' => 'required',
       //  'email' => 'required|email',
       //  'primary_phone' => 'required|unique:customers'
       // ]);


        $todaydate = date("Y-m-d");
        $date6day = now()->addDays(7)->format('Y-m-d');

        $order = new Order;
        $order->customer_Id = $request->customer_Id;
        $order->store_id = $request->store_id;
        $order->store_customer_Id= $request->store_customer_Id;
        $order->type= $request->type;
        $order->start_date= $request->start_date ?? $todaydate;
        $order->delivered_date= $request->delivered_date;
        $order->expected_delivery_date= $request->expected_delivery_date ?? $date6day;
        $order->total_amount= $request->total_amount;
        $order->advance= $request->advance;
        $order->balance= $request->balance;
        $order->status   = $request->status;
        $order->active   = $request->active;
        $order->save();
        return response()->json(["status"=>true,"message"=>"Order Create successfully"]);




        //
    }

    public function update(Request $request)
    {

        $todaydate = date("Y-m-d");
        $date6day = now()->addDays(7)->format('Y-m-d');
        // return $request->id;
        $order = Order::find($request->id);
        $order->customer_Id = $request->customer_Id;
        $order->store_id = $request->store_id;
        $order->store_customer_Id= $request->store_customer_Id;
        $order->type= $request->type;
        $order->start_date= $request->start_date ?? $todaydate;
        $order->delivered_date= $request->delivered_date;
        $order->expected_delivery_date= $request->expected_delivery_date ?? $date6day;
        $order->total_amount= $request->total_amount;
        $order->advance= $request->advance;
        $order->balance= $request->balance;
        $order->status= $request->status;
        $order->active= $request->active;
        $order->update();

        return response()->json(["status"=>true,"message"=>"Order Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}
