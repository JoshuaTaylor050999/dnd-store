<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    //
    public function store($request){
        $order = new Order();
        return $request->shippingAddress;
        $order->shippingAddress = $request->shippingAddress; 
        $order->shippingCity = $request->shippingCity; 
        $order->shippingCountry = $request->shippingCountry; 
        $order->shippingCountryCode = $request->shippingCountryCode; 
        $order->shippingCustomerName = $request->shippingCustomerName; 
        $order->shippingPhone = $request->shippingPhone; 
        $order->shippingProvince = $request->shippingProvince; 
        $order->shippingZip = $request->shippingZip; 

        $order->save(); 
        return response()->json(['Message' => 'Success'],200);


    }
}
