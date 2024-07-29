<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CodeDesc;
use App\Models\OrderActivity;
use App\Models\OrderPaymentLink;
use App\Models\OrderPaymentCharge;
use App\Models\Constant;
use App\Models\Customers;
use App\Models\Order;
use App\Traits\PayOrderTrait;
use App\Traits\CentralFuncTrait;

use Carbon\Carbon;
use Log;
 
class PayOrderController extends Controller
{
    use PayOrderTrait;
    use CentralFuncTrait;
    public function linkpayorder($ordno)
    {
        if (empty($ordno)) {
            abort(400, 'Parameter: $id not found.');
        }
        $currencytype = Constant::where('constantid', 1)->value('currencytype');

        if ($currencytype === null) {
            return response()->json(['error' => 'No results found'], 404);
        }

        $Order = Order::select(
            'tbl_orders.ordno', 
            'tbl_orders.orderbrno', 
            'tbl_orders.orderidpos', 
            'tbl_orders.orderstatus', 
            'tbl_orders.amount', 
            'tbl_orders.custid', 
            'tbl_orders.paymentstatus', 
            'cd.codevalue3 as source_type'

        )
            ->leftJoin('tbl_code_desc as cd', function($join) {
                $join->on('cd.codename', '=', 'tbl_orders.paymentchannelcode')
                    ->where('cd.groupname', 'PAYMENTCHANNEL');
            })
            ->where('tbl_orders.ordno', $ordno)
            ->orderBy('tbl_orders.orddate')
            ->first();
        if (!$Order) {
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Order not found',
                'data' =>  []
            ], 403);
        }else if($Order->paymentstatus === 'Y') {
            
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Order has been processed',
                'data' =>  []
            ], 403);

        }else{
            $custid = $Order->custid;
            $reference_number = $Order->ordno;
            $ref_1 = $Order->orderidpos;
            $ref_2 = $Order->orderbrno;
            $amount = $Order->amount;
            $source_type = $Order->source_type;
            $order_description = "Order ID: ".$Order->orderidpos.", Store:".$Order->branchcode.", Store Name: ".$Order->branchname.", Site Code: ".$Order->sap_site_code;
            $order_description = mb_substr($order_description, 0, 255, 'UTF-8');

            $codedesc = CodeDesc::select('codename', 'codevalue')
            ->where('groupname', 'PAYMENTLINK')
            ->whereNotNull('codename')
            ->whereNotNull('subcode')
            ->orderBy('sortid', 'asc')
            ->get();

            foreach ($codedesc as $row) {
                $paymentlinkurl = $row->codevalue;
            }
            $paymentlinkurlxx = $paymentlinkurl . "?q=". base64_encode($this->secured_encrypt($ordno));
            $paymentlinkurlshort = $paymentlinkurlxx;
            $currentDateTime = DB::select("SELECT NOW() as current_datetime")[0]->current_datetime;
            OrderPaymentLink::where('ordno', $ordno)
            ->where('paymentlinkstatus', 'Y')
            ->update([
                'paymentlinkstatus' => 'N',
                'modifieduserid' => '99999993',
                'modifiedname' => 'Web Site',
                'modifieddate' => $currentDateTime
            ]);
            $carbonDateTime = Carbon::parse($currentDateTime);
            $carbonDateTime->addMinutes(15);
            // // Insert new entry
            $newPaymentLink = OrderPaymentLink::create([
                'ordno' => $ordno,
                'custid' => $custid,
                'description' => $order_description,
                'amount' => $amount,
                'currency' => $currencytype,
                'source_type' => $source_type,
                'reference_order' => $reference_number,
                'ref_1' => $ref_1,
                'ref_2' => $ref_2,
                'paymentlinkurl' => $paymentlinkurl,
                'paymentlinkurlshort' => $paymentlinkurlshort,
                'paymentlinkcreated' => $currentDateTime,
                'paymentlinkexpired' =>  $carbonDateTime->addMinutes(15),
                'paymentinquirycheck' =>  $carbonDateTime->addMinutes(5),
                'paymentlinkstatus' => 'Y',
                'createduserid' => '99999993',
                'createdname' => 'Web site',
                'createddate' => $currentDateTime
            ]);
            $paymentlinkid = $newPaymentLink->paymentlinkid;
            $updateReferenceOrder = OrderPaymentLink::where('paymentlinkid', $paymentlinkid)
                ->update([
                    'reference_order' => $reference_number . '/' . $paymentlinkid,
                ]);

            $responseData = [
                'status' => 'success',
                'errormessage' => '',
                'data' => $paymentlinkurlshort
            ];
            return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
           
            
        }

    }
    
    public function getpaychannel()
    {
        // ค้นหา Order
        $paymentChannels = CodeDesc::where('groupname', 'PAYMENTCHANNEL')
            ->where('codevalue7', 'WEB')
            ->select('codename as payment_channel_code', 'codevalue as payment_channel_name', 'sortid as payment_channel_sort')
            ->get();

        if (!$paymentChannels) {
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Payment Channel not found',
                'data' =>  []
            ], 403);
        }
        
        // สร้าง JSON response
        $PayChannel = [];
        foreach ($paymentChannels  as $row) {
            $positem  = [
              
                'payment_channel_code' => $row->payment_channel_code,
                'payment_channel_name' => $row->payment_channel_name,
                'payment_channel_sort' => $row->payment_channel_sort,
              
            ];
            $PayChannel[] = $positem;
        }
        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $PayChannel
        ];
        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
    }



    // public function payorder($ordno)
    // {
    //     $order_payment_link = OrderPaymentLink::where('ordno', $ordno)
    //     ->where('paymentlinkstatus', 'Y')
    //     ->orderBy('ordno', 'asc')
    //     ->orderBy('paymentlinkexpired', 'desc')
    //     ->orderBy('paymentlinkid', 'desc')
    //     ->first([
    //         'paymentlinkid', 'ordno', 'description', 'amount', 'currency', 'custid',
    //         'source_type', 'reference_order', 'ref_1', 'ref_2', 'paymentlinkurl',
    //         'paymentlinkurlshort', 'paymentlinkcreated', 'paymentlinkexpired',
    //         DB::raw("(CASE 
    //                     WHEN TIMESTAMPDIFF(SECOND, NOW(), paymentlinkexpired) > 0 
    //                     THEN 'Y' 
    //                     ELSE 'N' 
    //                     END) AS paylinkstatus")
    //     ]);
    //     if ($order_payment_link) {

    //         $custid = $order_payment_link->custid;
    //         $customer = Customer::where('custid', $custid)
    //             ->select('bankcustid', 'savecard',
    //                 DB::raw("aes_decrypt(custfname,'TrueTouchXSandP') as custfname"),
    //                 DB::raw("aes_decrypt(custlname,'TrueTouchXSandP') as custlname"),
    //                 DB::raw("aes_decrypt(custemail,'TrueTouchXSandP') as custemail"))
    //             ->first();
    //         if (!$customer) {
    //             return response()->json(['message' => 'Customer not found for CUSTID ' . $custid], 404);
    //         }else{
    //             $order_payment_link->customer = $customer;
    //         }

    //         if (empty($order_payment_link->paymentlinkid) || $order_payment_link->paylinkstatus != "Y") {
    //             $activitytype = '03';
    //             $activitymessage = 'Link Created'; // Example message, adjust as needed
    //             $activitystatus = 'Y'; // Assuming activity creation is successful
    //             OrderActivity::create([
    //                 'ordno' => $ordno,
    //                 'activitydate' => now(),
    //                 'activitytype' => $activitytype,
    //                 'activitymessage' => $activitymessage,
    //                 'activitystatus' => $activitystatus,
    //                 'createduserid' => '99999990', // Example user ID, replace with actual value
    //                 'createdname' => 'Customer', // Example user name, replace with actual value
    //                 'createddate' => now()
    //             ]);
    //             $order_payment_link->errorlink = '1';
    //             $order_payment_link->errormessage = 'payment link time out';

    //         }else{
    //             $order_payment_link->errorlink = '0';
    //             $order_payment_link->errormessage = '';
    //             $codedesc = CodeDesc::select('codename', 'codevalue')
    //             ->where('groupname', 'WS-PAYMENT')
    //             ->orderBy('sortid', 'asc')
    //             ->get();
    //             foreach ($codedesc as $row) {
    //                 if ($row->codename == "APISKEY") {
    //                     $skey = $row->codevalue;
    //                     $order_payment_link->skey = $skey;
    //                 }
    //                 if ($row->codename == "SERVICENAME") {
    //                     $service_name = $row->codevalue;
    //                     $order_payment_link->service_name = $service_name;
    //                 }
    //                 if ($row->codename == "DESCRIPTION") {
    //                     $service_description = $row->codevalue;
    //                     $order_payment_link->service_description = $service_description;
    //                 }
    //                 if ($row->codename == "URLSERVICE") {
    //                     $urlservice = $row->codevalue;
    //                     $order_payment_link->urlservice = $urlservice;
    //                 }
    //                 if ($row->codename == "APIURL") {
    //                     $apiurl = $row->codevalue;
    //                     $order_payment_link->apiurl = $apiurl;
    //                 }
    //                 if ($row->codename == "APIKEY") {
    //                     $apikey = $row->codevalue;
    //                     $order_payment_link->apikey = $apikey;
    //                 }
    //                 if ($row->codename == "MERCHANTID") {
    //                     $mid = $row->codevalue;
    //                     $order_payment_link->mid = $mid;
    //                 }
    //             }
                
    //             $order_payment_link->fromlink = "../api/checkout.php";
    //             //$order_payment_link->source_type = 'qr';
    //             if ($order_payment_link->source_type == 'qr'){
    //                 $replied_OrderQr = $this->getOrderQr($urlservice, $order_payment_link->amount, $order_payment_link->description, $order_payment_link->reference_order,$skey);
    //                 $order_payment_link->fromlink = "../api/qrcheckout.php";
    //                 if ($replied_OrderQr['status'] == 'error') {
    //                     $order_payment_link->errorlink = '1';
    //                     $order_payment_link->errormessage = $replied_OrderQr['message'];
    //                     return response()->json($order_payment_link);
    //                 }
    //                 if ($replied_OrderQr["status"] == "success") {
    //                     $order_payment_link->order_id = $replied_OrderQr["id"];
    //                     $order_payment_link->mid = '';
    //                     $order_payment_link->customer->bankcustid = '';
    //                     $order_payment_link->currency = '';
    //                 }

    //             }else{

    //                 $order_payment_link->order_id ='';
    //             }
               
    //         }

    //         return response()->json($order_payment_link);
    //     }else{
    //         return response()->json(['errorlink'=>'1','errormessage' => 'not data']);
    //     }

    // }
   
    // public function paycheckout(Request $request)
    // {
        
    //     $ordno = $request->input('ordno');
    //     $amount = $request->input('amount');
    //     $currency = $request->input('currency');
    //     $description = $request->input('description');
    //     $source_type = $request->input('source_type');
    //     $reference_order = $request->input('reference_order');
    //     $ref_1 = $request->input('ref_1');
    //     $ref_2 = $request->input('ref_2');
    //     $skey = $request->input('skey');
    //     $urlcharge = $request->input('urlcharge');
    //     $bankcustid = $request->input('bankcustid');
    //     $custid = $request->input('custid');
    //     $token = $request->input('token');
    //     $saveCard = $request->input('saveCard');
    //     $mid = $request->input('mid');
    //     $paymentMethods = $request->input('paymentMethods');
    //     // Update savecard field in tbl_customer
    //     if ($saveCard === "true") {
    //         Customer::where('custid', $custid)->update(['savecard' => 'Y']);
    //     }

    //     $data = [
    //         "amount" => $amount,
    //         "currency" => $currency,
    //         "description" => $description,
    //         "source_type" => $paymentMethods,
    //         "mode" => $mode,
    //         "token" => $token,
    //         "reference_order" => $reference_order,
    //         "ref_1" => $ref_1,
    //         "ref_2" => $ref_2,
    //         "additional_data" => [
    //             "mid" => $mid
    //         ],
    //         "customer" => [
    //             "customer_id" => $bankcustid
    //         ]
    //     ];
    //     $chargeApi = $this->ChargeApi($data, $urlcharge, $skey);

    //     if (isset($chargeApi['error'])) {
    //         return response()->json(['error' => $chargeApi['error']], 500);
    //     }

    //     $httpcode = $chargeApi['httpcode'];
    //     $responseData = $chargeApi['responseData'];

    //     if ($httpcode != 200) {
    //         return response()->json([
    //             'error' => "HTTP Error: $httpcode",
    //             'response' => $responseData
    //         ], $httpcode);
    //     } else {
    //         OrderPaymentCharge::create([
    //             'paymentchargestatus' => 'W',
    //             'chargeno' => $responseData["id"],
    //             'tokenno' => $token,
    //             'chargestatus' => $responseData["status"],
    //             'reference_order' => $responseData["reference_order"],
    //             'ordno' => $ordno,
    //             'cardno' => $responseData["source"]['card_masking'],
    //             'custid' => $custid,
    //             'createduserid' => '99999990',
    //             'createdname' => 'customer',
    //             'createddate' => now()
    //         ]);
    //         OrderPaymentLink::where('reference_order', $reference_order)
    //             ->update([
    //                 'paymentlinkstatus' => 'W',
    //                 'token' => $token,
    //                 'modifieduserid' => '99999990',
    //                 'modifiedname' => 'Customer',
    //                 'modifieddate' => now()
    //             ]);
    //         if (!empty($responseData["redirect_url"])) {
    //             $urlLink = $responseData["redirect_url"];
    //         } elseif (isset($responseData['code']) && $responseData['code'] == 'ref_number_already_exist') {
    //             $urlLink = "../api/payment_error.php?iResult=3";
    //         } else {
    //             $urlLink = null;
    //         }
    //         return response()->json([
    //             'error' => '',
    //             'response' => $urlLink
    //         ]);
    //     }
    // }
}
