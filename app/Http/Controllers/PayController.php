<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
 
class PayController extends Controller
{
   
   public function index()
   {
        return view('payment');
   }
   public function pay(Request $request){
 
     $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "Confirm Appointment Booking - E-doctor",
            "amount" => $request->amount,
            "buyer_name" => "$request->name",
            "send_email" => true,
            "email" => "$request->email",
            "phone" => "$request->mobile_number",
            "token" => "$request->token",
            "redirect_url" => "http://e-doctor.frb.io/pay-success"
            ));
             
            header('Location: ' . $response['longurl']);
            exit();
    }catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
 }
 
 public function success(Request $request){
     try {
 
        $api = new \Instamojo\Instamojo(
            config('services.instamojo.api_key'),
            config('services.instamojo.auth_token'),
            config('services.instamojo.url')
        );
 
        $response = $api->paymentRequestStatus(request('payment_request_id'));
 
        if( !isset($response['payments'][0]['status']) ) {
           dd('payment failed');
        } else if($response['payments'][0]['status'] != 'Credit') {
             dd('payment failed');
        } 
      }catch (\Exception $e) {
         dd('payment failed');
     }
    dd($response);
  }
}