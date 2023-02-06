<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;


class StripePaymentController extends Controller
{
    //
    public function stripePost(Request $request)
    {
        try{
          // Create Card Token
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
              );
            $token = $stripe->tokens->create([
                'card' => [
                  'number' => $request->number,
                  'exp_month' =>  substr($request->expiry_date,5,7),
                  'exp_year' => substr($request->expiry_date,0,4),
                  'cvc' => $request->cvc,
                ],
              ]);
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          // Create Card Charge

            $response = $stripe->charges->create([
                'amount' => '1000',
                'currency' => 'gbp',
                'source' => $token->id,
                'description' => 'My First Test Charge (created for API docs at https://www.stripe.com/docs/api)',
              ]);

              //Generate Order
              $order = new Order();
                $order->shippingAddress = $request->street_address;
                $order->shippingCity = $request->town_city;
                $order->shippingCountry = $request->country;
                $order->shippingCountryCode = $request->country;
                $order->shippingCustomerName = $request->first_name;
                $order->shippingPhone = $request->phone;
                $order->shippingProvince = $request->county;
                $order->shippingZip = $request->postcode;
              $order->save();
              

              //Create CJ order
              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://developers.cjdropshipping.com/api2.0/v1/shopping/order/createOrder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                  "fromCountryCode": "CN",
                  "logisticName": "CJPacket Euro Sensitive",
                  "products": [
                      {
                          "quantity": 1,
                          "sellPrice": 10.0,
                          "shippingName": "cloud_mall: 19516036",
                          "vid": "1436984757291454464"
                      }
                  ],
                  "shippingAddress": "'.$request->street_address.'",
                  "shippingCity": "'.$request->town_city.'",
                  "shippingCountry":  "'.$request->country.'",
                  "shippingCountryCode": "'.strtoupper($request->country).'",
                  "shippingCustomerName": "'.$request->first_name.'",
                  "shippingPhone": "'.$request->phone.'",
                  "shippingProvince": "'.$request->county.'",
                  "shippingZip": "'.$request->postcode.'"
              }',
                CURLOPT_HTTPHEADER => array(
                  'CJ-Access-Token: '.env('CJ_KEY'),
                  'Content-Type: application/json'
                ),
              ));
              
              $response = curl_exec($curl);
              
              curl_close($curl);

              $result = json_decode($response, true);
              $orderId = $result['data'];
              //Get CJ Order Code

              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://developers.cjdropshipping.com/api2.0/v1/shopping/order/getOrderDetail?orderId='.$orderId,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                  'CJ-Access-Token: '.env('CJ_KEY')
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);
              $result = json_decode($response, true);
              $cjOrderCode = $result['data']['cjOrderCode'];

              

              // Confirm CJ order
              $curl = curl_init();

              curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://developers.cjdropshipping.com/api2.0/v1/shopping/order/confirmOrder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PATCH',
                CURLOPT_POSTFIELDS =>'{
                  "orderId": "'.$cjOrderCode.'"
              }',
                CURLOPT_HTTPHEADER => array(
                  'CJ-Access-Token: '.env('CJ_KEY'),
                  'Content-Type: application/json'
                ),
              ));

              $response = curl_exec($curl);

              curl_close($curl);


            return response()->json(['Message' => 'Success'],200);
        }
        catch(Exception $ex){
            return response()->json(['Message' => 'Error'],500);

        }
    }
}
