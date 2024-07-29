<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\PayOrderController;
use App\Http\Controllers\API\v1\MudjaiController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CodeDesc;
use App\Models\Branch;
use App\Models\CustomerAddress;
use App\Models\Customers;
use App\Models\Order;
use App\Models\CustomerTaxAddress;
use App\Models\OrderDetail;
use App\Models\OrderActivity;
use App\Models\Constant;
use App\Models\ServiceRequest;
use App\Models\ServiceTicketLog;
use App\Models\ShoppingCart;
use App\Models\ServiceTicket;
use App\Models\ZShoppingCartMain;
use App\Models\Menu;
use App\Models\BorPlu;
use App\Models\BorPmMemberHasPlu;
use App\Models\BorPmMember;
use DateTime;
use Carbon\Carbon;

//use OpenApi\Annotations as OA;

use App\Traits\CentralFuncTrait;

use Log;
/**
 * @group User management
 *
 * APIs for managing users
 */
class OrderController extends Controller
{
    use CentralFuncTrait;
   
     
    public function getorder(Request $request, $ordno = null)
    {
        if (is_null($ordno)) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Order ID is required',
                'data' => []
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }

        $order = Order::where('ordno', $ordno)
            ->leftJoin('branch as b', 'b.id', '=', 'tbl_orders.branchid')
            ->leftJoin('customer as c', 'c.id', '=', 'tbl_orders.custid')
            ->leftJoin('customer_address as ad', 'ad.id', '=', 'tbl_orders.addressid')
            ->leftJoin('tbl_code_desc as cd', function($join) {
                $join->on('cd.codename', '=', 'tbl_orders.ordermode')
                ->where('cd.groupname', '=', 'ORDERMODE');
            })
            ->select(
                'tbl_orders.ordno', 'tbl_orders.orderbrno', 'tbl_orders.orderidpos', 'tbl_orders.branchid','tbl_orders.custid','channelname',
                'tbl_orders.orderstatus', 'tbl_orders.preamount', 'tbl_orders.amount', 'tbl_orders.bigorderstatus',
                'tbl_orders.ordremark', 'tbl_orders.contactname', 'tbl_orders.contacttel', 'tbl_orders.createdname',
                'tbl_orders.paymentchannel', 'tbl_orders.paymentchannelcode', 'tbl_orders.paymentstatus',
                'tbl_orders.paymentrefcode', 'tbl_orders.posstatus', 'tbl_orders.delistatus', 'tbl_orders.completestatus',
                'tbl_orders.taxid', 'tbl_orders.totalcustdiscount', 'tbl_orders.totalpromodiscount',
                'tbl_orders.totaldiscountkeyin', 'tbl_orders.orddate', 'tbl_orders.orderestimatedate',
                'tbl_orders.ordermode', 'cd.codename as ordermodecode', 'cd.codevalue as ordermodename',
                'tbl_orders.channelcode', 'b.branchcode', 'b.name as branchname', 'b.sap_site_code', 'b.posserver',
                'b.branchdomain', 'c.first_name', 'c.last_name', 'c.email',
                DB::raw("concat_ws(' ', ifnull(ad.building_name, ''), ifnull(ad.room_number, ''), ifnull(ad.floor_number, ''),  case when ad.province = 'กรุงเทพมหานคร' then concat('แขวง ', ifnull(ad.subdistrict, '')) else concat('ตำบล ', ifnull(ad.subdistrict, '')) end, case when ad.province = 'กรุงเทพมหานคร' then concat('เขต ', ifnull(ad.district, '')) else concat('อำเภอ ', ifnull(ad.district, '')) end, case when ad.province = 'กรุงเทพมหานคร' then ifnull(ad.province, '') else concat('จ. ', ifnull(ad.province, '')) end, ifnull(ad.postcode, '')) as contactaddress"),
                'ad.subdistrict', 'ad.district', 'ad.province', 'ad.postcode', 'ad.address1', 'ad.latitude', 'ad.longitude'
            )
            ->orderBy('tbl_orders.orddate')
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Order not found',
                'data' =>  []
            ], 403);
        }
    
        // Process the order details
        $custid=$order->custid;
        $channelname=$order->channelname;
        $contactname = $order->contactname;
        $contactphone = $order->contacttel;
        $createdname = $order->createdname;
        $contactaddress = $order->contactaddress;
        $addresskhwengname = $order->subdistrict;
        $addresskhetname = $order->district;
        $addressprovincename = $order->province;
        $addresszipcode = $order->postcode;
        $custfname = $order->first_name;
        $custlname = $order->last_name;
        $custemail = $order->email;
        $contactaddressremark = "(ส่ง:".$contactname."/".$contactphone.") ".trim($order->contactaddress);
        $map_latitude = $order->latitude;
        $map_longitude = $order->longitude;
        $map_url = "https://maps.google.com/?q=".$map_latitude.",".$map_longitude;
        $channelcode = $order->channelcode;
        $ordno = $order->ordno;
        $orderidpos = $order->orderidpos;
        $orderdate = $order->orddate;
        $orderestimatedate = $order->orderestimatedate;
        $orderremark = $order->ordremark;
        $branchid = $order->branchid;
        $branchcode = $order->branchcode;
        $branchname = $order->branchname;
        $sap_site_code = $order->sap_site_code;
        $posserver = $order->posserver;
        $preamount = $order->preamount;
        $amount = $order->amount;
        $orderstatus = $order->orderstatus;
        $paymentchannel = $order->paymentchannel;
        $paymentchannelcode = $order->paymentchannelcode;
        $paymentstatus = $order->paymentstatus;
        $paymentdate = $order->paymentdate;
        $paymentrefcode = $order->paymentrefcode;
        $taxid = $order->taxid;
        $taxinvoice = !empty($taxid) ? "Y" : "N";
        $posstatus = $order->posstatus;
        $delistatus = $order->delistatus;
        $completestatus = $order->completestatus;
        //$ordermode = $order->ordermode;
        $ordermodecode = $order->ordermodecode;
        $ordermodename = $order->ordermodename;
        $totalcustdiscount = $order->totalcustdiscount;
        $totalpromodiscount = $order->totalpromodiscount;
        $totaldiscountkeyin = $order->totaldiscountkeyin;
        $totaldiscount = $totalcustdiscount + $totalpromodiscount + $totaldiscountkeyin;
        $discountmessage = "";
        if ($totalpromodiscount > 0) { 
            $discountmessage .= " - Promotion (". number_format($totalpromodiscount, 2) .")";
        }
        if ($totalcustdiscount > 0) { 
            $discountmessage .= " - Member (". number_format($totalcustdiscount, 2) .")";
        }
        if ($totaldiscountkeyin > 0) { 
            $discountmessage .= " - Key-in (". number_format($totaldiscountkeyin, 2) .")";
        }
        $totaldiscountmessage = $discountmessage;
        $earnest = 0;
      
        $posorder = [
            "order_id" => $ordno,
            "order_pos_id" => $orderidpos,
            "branch_code" => $branchcode,
            "branch_name" => $branchname,
            "order_channel" => $channelcode,
            "order_channel_name" => $channelname,
            "order_datetime" => $orderdate,
            "order_senddatetime" => $orderestimatedate,
            "order_mode" => $ordermodecode,
            "order_mode_name" => $ordermodename,
            "payment_type" => $paymentchannelcode,
            "payment_type_name" => $paymentchannel,
            "order_special_message" => $orderremark,
            
        ];

        $poscustomer = [
            "customer_fname" => $custfname,
            "customer_lname" => $custlname,
            "customer_email" => $custemail,
            "customer_address" => $contactaddress,
            "customer_address_remark" => $contactaddressremark,
            "customer_district" => $addresskhwengname,
            "customer_area" => $addresskhetname,
            "customer_province" => $addressprovincename,
            "customer_postcode" => $addresszipcode,
            "contactname" => $contactname,
            "contactphone" => $contactphone,
            "map_latitude" => $map_latitude,
            "map_longitude" => $map_longitude,
            "tax_invoice" => $taxinvoice
        ];
      

        if ($taxinvoice == "Y") {
            $tax = CustomerTaxAddress::where('tax_id', $taxid)
            ->where('customer_id', $custid)
            ->first();
           
            if ($tax) {
                $postax = [
                    "tax_no" => $tax->tax_id,
                    "company_name" => $tax->company_name,
                    "company_address" => $tax->address,
                    "company_district" => $tax->subdistrict,
                    "company_area" => $tax->district,
                    "company_province" => $tax->province,
                    "company_postcode" => $tax->postcode,
                    "company_tel" => $tax->phone_number
                ];

                $poscustomer['tax_information'] = $postax;
            }
        }

        $orderDetails = OrderDetail::select(
            'productid',
            'productcode',
            'productname',
            'qty',
            'unitprice',
            DB::raw('(qty * unitprice) as amount'),
            'ordermenuremark',
            'prodmainid'
        ) 
            ->where('ordno', $ordno)
            ->orderBy('layerid')
            ->orderBy('indexset')
            ->orderBy('sortsetid')
            ->get();
        $itemno = 1;
        $subitemno = 1;
        $items = [];

        $subtotal=0;
        foreach ($orderDetails as $detail) {
            if (!empty($detail->prodmainid)) {
                $prodtype = "1";
                $possubitem = [
                    "sub_item_no" => $subitemno,
                    "sub_item_id" => $detail->productid,
                    "sub_item_code" => $detail->productcode,
                    "sub_item_name" => $detail->productname,
                    "sub_item_remark" => $detail->ordermenuremark,
                    "sub_item_qty" => $detail->qty,
                    "sub_item_unitprice"=> $detail->ordermenuremark
                ];

                
                $subitemno++;
                $items[count($items) - 1]['item_indexset'] = $prodtype;
                $items[count($items) - 1]['subitems'][] = $possubitem;
                
            } else {
                $prodtype = "0";
                $subitemno = 1;
                $positem = [
                    "item_no" => $itemno,
                    "item_id" => $detail->productid,
                    "item_code" => $detail->productcode,
                    "item_name" => $detail->productname,
                    "item_unitprice" => $detail->unitprice,
                    "item_qty" => $detail->qty,
                    //"item_amount" => $detail->amount,
                    "item_remark" => $detail->ordermenuremark,
                    "item_indexset" => $prodtype
                ];
                $subtotal += ($detail->unitprice*$detail->qty);
                $items[] = $positem;
                $itemno++;
            }
        }

        $delifee=0;
        if ($ordermodecode==='D'){
            $delifee=50; 
            $nettotal=($delifee+$subtotal);
        }else{

            $nettotal=$subtotal;
        }
        $postData = [
            "order" => $posorder,
            "customer" => $poscustomer,
            "items" => $items,
            "amounts" => [
                "delifee"=>  $delifee,
                "subtotal" => $subtotal,
                //"discount" => $totaldiscount,
                "discount_member"=>$totalcustdiscount,
                "discount_promotion"=>$totalpromodiscount,
                "discount_special"=>$totaldiscountkeyin,
                "discount_message" => substr($totaldiscountmessage, 0, 100),
                "earnest" => $earnest,
                "nettotal" => $nettotal
            ]

        ];
        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $postData
        ];
        
        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
    }
 
    public function getbycustomer($custid)
    {
      
        if (is_null($custid)) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Customer ID is required',
                'data' => []
            ], 400, [], JSON_UNESCAPED_UNICODE);
        }
        $Order = Order::where('tbl_orders.custid', $custid)
            ->leftJoin('branch as b', 'b.id', '=', 'tbl_orders.branchid')
            ->leftJoin('customer as c', 'c.id', '=', 'tbl_orders.custid')
            ->leftJoin('tbl_code_desc as cd', function($join) {
                $join->on('cd.groupname', '=', DB::raw("'ORDERMODE'"))
                    ->on('cd.codename', '=', 'tbl_orders.ordermode');
            })
            ->leftJoin('tbl_code_desc as cd2', function($join) {
                $join->on('cd2.groupname', '=', DB::raw("'ORDERSTATUS'"))
                    ->on('cd2.codename', '=', 'tbl_orders.orderstatus');
            })
            ->select(
                'tbl_orders.ordno','tbl_orders.orderidpos','tbl_orders.orderstatus',
                'cd2.codevalue as orderstatusname','tbl_orders.amount','tbl_orders.contactname','tbl_orders.contacttel',
                'tbl_orders.createdname','tbl_orders.paymentchannel','tbl_orders.paymentchannelcode','tbl_orders.taxid',
                DB::raw("date_format(tbl_orders.orddate, '%Y-%m-%d %H:%i:%s') as orderdate"),
                DB::raw("date_format(tbl_orders.orderestimatedate, '%Y-%m-%d %H:%i:%s') as orderestimatedate"),
                'tbl_orders.ordermode','cd.subcode as ordermodecode','cd.codevalue as ordermodename',
                'tbl_orders.channelcode', 'tbl_orders.channelname','tbl_orders.branchid','b.branchcode','b.name'
            )
            ->orderBy('tbl_orders.orddate')
            ->get();
        
        if ($Order ->isEmpty()) {
            
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Order not found',
                'data' =>  []
            ], 403);
           
        }
        $postData = [];
        foreach ($Order  as $row) {
            $positem = [
                "order_no" => $row->ordno,
                "order_pos_id" => $row->orderidpos,
                "order_channel" => $row->channelcode,
                "order_channel_name" => $row->channelname,
                "order_datetime" => $row->orderdate,
                "order_senddatetime" => $row->orderestimatedate,
                "order_mode" => $row->ordermodecode,
                "order_mode_name" => $row->ordermodename,
                "order_status" => $row->orderstatus,
                "order_status_name" => $row->orderstatusname,
                "payment_type" => $row->paymentchannelcode,
                "payment_type_name" => $row->paymentchannel,
                "amount" => $row->amount,
            ];

            $postData[] = $positem;
        }
        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $postData
        ];
        
        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
    }
    

    public function getorderstatus($ordno)
    {
        $Order = Order::where('ordno', $ordno)
        ->leftJoin('tbl_code_desc as cd2', function($join) {
            $join->on('cd2.groupname', '=', DB::raw("'ORDERSTATUS'"))
                ->on('cd2.codename', '=', 'tbl_orders.orderstatus');
        })
        ->select('tbl_orders.ordno', 'tbl_orders.orderidpos', 'tbl_orders.orderstatus', 'cd2.codevalue as orderstatusname')
        ->orderBy('tbl_orders.orddate')
        ->get();
        // ตรวจสอบว่าพบข้อมูล Order หรือไม่
        if ($Order->isEmpty()) {
            return response()->json([
                    'status' => 'not success',
                    'errormessage' => 'Order not found',
                    'data' =>  []
                ], 403);
        }
        $postData = [];
        foreach ($Order as $row) {
            $positem = [
                'order_id' => $row->ordno,
                'order_pos_id' => $row->orderidpos,
                'order_status' => $row->orderstatus,
                'order_status_name' => $row->orderstatusname,
            ];
            $postData[] = $positem;
        }
        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $postData
        ];
        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
  
    }

   
    public function getordpay($ordno)
    {
        // ค้นหา Order
        $Order = Order::where('ordno', $ordno)
            ->select(
                'ordno',
                'orderidpos',
                'paymentchannelcode',
                'paymentchannel',
                'paymentstatus',
                'cardno',
                DB::raw("DATE_FORMAT(paymentdate, '%d/%m/%Y %H:%i:%s') as paymentdate")
            )
            ->orderBy('orddate')
            ->get();

        if (!$Order) {
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Order not found',
                'data' =>  []
            ], 403);
        }

        // สร้าง JSON response
        $orderPay = [];
        foreach ($Order  as $row) {
            $positem  = [
                'order_id' => $row->ordno,
                'order_pos_id' => $row->orderidpos,
                'payment_channel_code' => $row->paymentchannelcode,
                'payment_channel_name' => $row->paymentchannel,
                'payment_status' => $row->paymentstatus,
                'card_no' => $row->cardno,
                'payment_date' => $row->paymentdate,
            ];
            $orderPay[] = $positem;
        }
        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $orderPay
        ];
        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function sendOrder(Request $request)
    {
        // Validate the incoming request data
        $data = $request->all();
        //---------------------------------------------------- check empty -------------------------------------//
        $requiredFields = [
            'custid', 'addressid', 'branchid', 'contacttel', 'contactname',
            'custfname', 'orderstatus',  'orderestimatedate',
            'preamount', 'amount', 'channelcode',  'taxid',
            'paymentchannelcode', 'paymentstatus',
             'totalcustdiscount',
            'totalpromodiscount', 'totaldiscountkeyin', 'ordermode','ordertypestatus', 'orderapprove','order_detail'
        ];

        // ตรวจสอบฟิลด์ที่ต้องการ
        $validationResult = $this->validateFields($data, $requiredFields);
       

        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid data',
                'data' => $validationResult['messages'],
            ], 400); // HTTP status 400 คือ Bad Request
        }
        //-------------------------------------- check datetime -------------------------------------------------//
        $dateTimeFields = [
             'orderestimatedate'
            
        ];
        $validationResult = $this->validateDateTimeFields($data, $dateTimeFields);

        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid datetime format',
                'data' => $validationResult['messages']
            ], 400); // HTTP status 400 คือ Bad Request
        }
        //------------------------------------------check number ----------------------------------------------//
        $numericFields = [
            'custid', 'addressid',  'preamount', 'amount', 'taxid',
             'totalcustdiscount', 'totalpromodiscount',
            'totaldiscountkeyin',
        ];

        // ตรวจสอบฟิลด์ที่เป็นตัวเลขทั้งหมดในข้อมูลหลัก
        $validationResult = $this->validateNumericFields($data, $numericFields);

        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid numeric format',
                'data' =>$validationResult['messages']
            ], 400); // HTTP status 400 คือ Bad Request
        }

        //-------------------------------------check empty order detail ---------------------------------------------//
        if (isset($data['order_detail'])) {
            foreach ($data['order_detail'] as $index => $detail) {
                $detailRequiredFields = [
                     'productid', 'productname', 'productcode',
                    'ordermenuremark', 'productgroupid', 'productgroupname', 'qty', 'unitprice',
                    'indexset', 'sortsetid', 'layerid', 'setflag' 
                    
                ];

                $detailValidationResult = $this->validateFields($detail, $detailRequiredFields, 'order_detail.' . $index);

                if (!$detailValidationResult['isValid']) {
                    return response()->json([
                        'status' =>'error' ,
                        'errormessage' =>'Invalid data in order_detail' ,
                        'data' =>$detailValidationResult['messages']
                    ], 400); // HTTP status 400 คือ Bad Request
                }
            }
        }

        //-----------------------------------------------------check order detail datetime-----------------------------------------------//

        if (isset($data['order_detail'])) {
            foreach ($data['order_detail'] as $index => $detail) {
                $detailDateTimeFields = ['createddate'];

                $validationResult = $this->validateDateTimeFields($detail, $detailDateTimeFields, 'order_detail.' . $index);
                if (!$validationResult['isValid']) {
                    return response()->json([
                        'status' => 'error',
                        'errormessage' =>'Invalid datetime format in order_detail' ,
                        'data' =>$validationResult['messages']
                    ], 400); // HTTP status 400 คือ Bad Request
                }
            }
        }

         //-----------------------------------------------------check order detail number-----------------------------------------------//
         if (isset($data['order_detail'])) {
            foreach ($data['order_detail'] as $index => $detail) {
                $detailNumericFields = [
                     'productgroupid', 'qty', 'unitprice', 'indexset', 'sortsetid', 'layerid'
                ];

                $validationResult = $this->validateNumericFields($detail, $detailNumericFields, 'order_detail.' . $index);

                if (!$validationResult['isValid']) {
                    return response()->json([
                        'status' => 'error',
                        'errormessage' =>'Invalid numeric format in order_detail',
                        'data' => $validationResult['messages']
                    ], 400); // HTTP status 400 คือ Bad Request
                }
            }
        }
        
        // เริ่ม Transaction
        \DB::beginTransaction();
        try {
            // สร้าง Order
            $currentDateTime = DB::select("SELECT NOW() as current_datetime")[0]->current_datetime;
            // Assume these variables are already set
            $next_order_date = $data["orderestimatedate"]; // your next order date input

            // ดึงข้อมูลที่ต้องการทั้งหมดในครั้งเดียว
            $codedescs = CodeDesc::whereIn('groupname', ['DELIVERYCONST', 'CHANNEL', 'PAYMENTCHANNEL'])
            ->whereIn('codename', [
                'PROMISETIME',
                $data['channelcode'],
                $data['paymentchannelcode']
            ])->get()->keyBy(function ($item) {
                return $item->groupname . '-' . $item->codename;
            });

            $promisetime = $codedescs['DELIVERYCONST-PROMISETIME']->codevalue ?? null;
            $channelname = $codedescs['CHANNEL-' . $data['channelcode']]->codevalue ?? null;
            $paymentchannel = $codedescs['PAYMENTCHANNEL-' . $data['paymentchannelcode']]->codevalue ?? null;
            $payment_type = $codedescs['PAYMENTCHANNEL-' . $data['paymentchannelcode']]->codevalue8 ?? null;

            //$promisetime = 60; // your promised time in minutes
            if (!empty($next_order_date)) { // advance order
                $timestamp = strtotime(str_replace('/', '-', $next_order_date));
                $new_next_order_date = date("Y-m-d H:i:s", $timestamp);

                $results = DB::select("
                    SELECT 
                        DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AS conf_date,
                        CASE 
                            WHEN TIMESTAMPDIFF(MINUTE, NOW(), ?) < 60 THEN NOW()
                            ELSE DATE_SUB(?, INTERVAL ? MINUTE)
                        END AS ord_start,
                        CASE 
                            WHEN TIMESTAMPDIFF(MINUTE, NOW(), ?) < 60 THEN DATE_ADD(NOW(), INTERVAL 60 MINUTE)
                            ELSE ?
                        END AS ord_rcv
                ", [$new_next_order_date, $new_next_order_date, $promisetime, $new_next_order_date, $new_next_order_date]);

                if ($results) {
                    $ts_ord_start = $results[0]->ord_start;
                    $ts_conf_date = $results[0]->conf_date;
                    $ts_ord_rcv = $results[0]->ord_rcv;
                }
            } else { // now order
                $results = DB::select("
                    SELECT 
                        DATE_ADD(NOW(), INTERVAL ? MINUTE) AS esitimatetime,
                        DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AS todaydaytime
                ", [$promisetime]);

                if ($results) {
                    $ts_ord_start = $results[0]->todaydaytime;
                    $ts_conf_date = $results[0]->todaydaytime;
                    $ts_ord_rcv = $results[0]->esitimatetime;
                }
            }
            $branchid = $data['branchid'];
            // ดึงข้อมูล branch
            $branch = Branch::find($branchid);
            $currentDate = now()->format('ym');
            // สร้าง orderidpos และ ordbrno
            $orderidpos = sprintf("%s-%s%05d", $branch->branchcode, $currentDate, $branch->orderid);
            $ordbrno = sprintf("%s/%05d", $branch->branchcode, $branch->orderid);
            $branchname = $branch->name;
            $branchcode = $branch->branchcode;
            // อัปเดต orderid ในตาราง branch
            $branch->orderid += 1;
            $branch->save();
            // Set order dates
            $data['orddate']= $currentDateTime;
            $data['firstcreateddatetime']= $currentDateTime;
            $data['orderconfirmdate'] = $ts_conf_date;
            $data['orderstartdate'] = $ts_ord_start;
            $data['orderestimatedate'] = $ts_ord_rcv;
            $data['createduserid'] = '99999996';
            $data['createdname'] = 'Website';
            $data['createddate'] = $currentDateTime;
            $data['firstcreateduserid'] = '99999996';
            $data['firstcreatedname'] = 'Website';
            $data['orderwssuccess'] = 'Y';
            $data['orderwssuccessdate'] = $currentDateTime;
            $data['orderidpos'] = $orderidpos;
            $data['ordbrno'] = $ordbrno;
            $data['channelname'] = $channelname;
            $data['paymentchannel'] = $paymentchannel;
            //---------------------------- คำนวน pay total -----------------------//




            //---------------------------------------------------------------------// 
           
            // Create order
            $order = Order::create($data);
            $reforder = $order->ordno;
            // Create order details
            foreach ($data['order_detail'] as $detail) {
                $detail['ordno'] = $reforder;
                $detail['createduserid'] = '99999996';
                $detail['createdname'] = 'Website';
                $detail['createddate'] = $currentDateTime;
               // save order
                OrderDetail::create($detail);
            }
            //----------------------------------------------------------------------//
            $activityData = [
                'ordno' => $reforder,
                'activitydate' => $currentDateTime,
                'activitytype' => '01',
                'activitymessage' => $orderidpos,
                'activitystatus' => 'Y',
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            OrderActivity::create($activityData);
            $customerId = $data['custid'];
            $customer = Customers::where('id', $customerId)->first();
            if ($customer) {
                $customer->update([
                    'lastcontactdate' =>  $currentDateTime,
                    'lastorderdate' =>  $currentDateTime,
                    'ordercount' => DB::raw('ordercount + 1')
                ]);
            }
            //---------------------------------------------------------------------//
            // ##### Service Request ##### //
            $sr = [
                'custid' => $customerId,
                'channelid' => $data['channelcode'],
                'channelcode' => $data['channelcode'],
                'channelname' =>  $channelname,
                'contactphone' => $data['contacttel'],
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            $serviceRequest = ServiceRequest::create($sr);
            // รับค่า srno จากการสร้าง record
            $srno = $serviceRequest->srno; // assuming 'srno' is the primary key and auto-incrementing field in 'tbl_service_request'
            // ##### Ticket ##### //
            $catid = "1";
            $catcode =  "O";
            $catname =  "ออเดอร์";
            $subcatid = "1";
            $subcatcode =  "O01";
            $subcatname =  "ออเดอร์";
            $subcatemail = "N";
            $subcatsms = "N";
            $subcatws = "N";
            if ($data['ordermode']== "P") {
                $cattypeid = "2";
                $cattypename = "รับเองที่สาขา";
            } else {
                $cattypeid = "1";
                $cattypename = "จัดส่ง";
            }
            $ticketdetail = "New Order";
            $ticketsolution = "";  
            $ticketstatusid	 = "8";
            $ticketstatuscode = "C";
            $ticketstatusname = "ดำเนินการเรียบร้อย";
            $ticketstatustype = "C";
            $ticketstatussms = "N";
            $ticketstatusemail = "N";
            $ticketstatusspecial = "N";
            $firstcallresolution = "N";
            $ticketattachfile = "0";
            $ticketData = [
                'srno' => $srno,
                'custid' => $customerId,
                'catid' => $catid,
                'catcode' => $catcode,
                'catname' => $catname,
                'subcatid' => $subcatid,
                'subcatcode' => $subcatcode,
                'subcatname' => $subcatname,
                'subcatsms' => $subcatsms,
                'subcatemail' => $subcatemail,
                'subcatws' => $subcatws,
                'ticketdetail' => $ticketdetail,
                'ticketsolution' => $ticketsolution,
                'ticketstatusid' => $ticketstatusid,
                'ticketstatuscode' => $ticketstatuscode,
                'ticketstatusname' => $ticketstatusname,
                'ticketstatustype' => $ticketstatustype,
                'ticketstatussms' => $ticketstatussms,
                'ticketstatusemail' => $ticketstatusemail,
                'firstcallresolution' => $firstcallresolution,
                'ticketattachfile' => $ticketattachfile,
                'cattypeid' => $cattypeid,
                'cattypename' => $cattypename,
                'branchid' => $branchid,
                'branchcode' => $branchcode,
                'branchname' => $branchname,
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            if ($ticketstatuscode == "C") {
                $ticketData['closeduserid'] = '99999996';
                $ticketData['closedname'] = 'Website';
                $ticketData['closeddate'] = $currentDateTime;
            }
            //---------------------------------------------------//
            // สร้าง record ใหม่ในตาราง tbl_service_ticket
            $ServiceTicket = ServiceTicket::create($ticketData);
            $ticketid = $ServiceTicket->ticketid;
            // ##### Ticket Log ##### //
            $ticketLogData = [
                'ticketid' => $ticketid,
                'srno' => $srno,
                'custid' => $customerId,
                'ticketworklog' => $ticketsolution,
                'ticketstatusid' => $ticketstatusid,
                'ticketstatuscode' => $ticketstatuscode,
                'ticketstatusname' => $ticketstatusname,
                'ticketstatustype' => $ticketstatustype,
                'ticketstatussms' => $ticketstatussms,
                'ticketstatusemail' => $ticketstatusemail,
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            // สร้าง record ใหม่ในตาราง tbl_service_ticket_log
            $serviceTicketLog = ServiceTicketLog::create($ticketLogData);
            // รับค่า ticketlogid จากการสร้าง record
            $ticketlogid = $serviceTicketLog->ticketlogid;
           
            //-----------------call getpaymentlink --------------------------//
            if  ($payment_type === 'PAY'){
                $payOrderController = new PayOrderController();
                $payresponse = $payOrderController->linkpayorder($reforder);
                $responseData = json_decode($payresponse->getContent(), true);
                // ทำงานกับ responseData
                if ($responseData['status'] === 'success') {
                    $paylink = $responseData['data'];
                } else {
                    $paylink="";
                }
            }else{
                $paylink="";
            }
            //--------------------get order----------------------------------//
            $ordresponse =  $this->getorder($request,$reforder);
            $responseOrd = json_decode($ordresponse->getContent(), true);
            if ($responseOrd['status'] === 'success') {
                $OrderData = $responseOrd['data'];
                $OrderData['paymentlink']=$paylink;
            } else {
                $OrderData="";
            }
            //---------------------------------------------------------------//
             // Commit Transaction
            \DB::commit();
            
            $responseData = [
                'status' => 'success',
                'errormessage' => '',
                'data' => $OrderData
            ];
            return response()->json($responseData, 201, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();

            return response()->json([
                'status' => 'error',
                'errormessage' => $e->getMessage(),
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function send2Order(Request $request)
    {
       // {
            //     "custid": 2,
            //     "refmainid":"22"
            //     "addressid": 1000001,
            //     "branchid": "1000",
            //     "contacttel": "0811111111",
            //     "contactname": "ทดสอบ",
            //     "orderestimatedate": "2024-07-15 18:00:00",//--->ถ้า order ทันทีเอา now()+60 ตอน checkout หรือ order จอง เอาวันเวลาที่ลูกค้ารับสินค้า
            //     "channelcode": "2", ----> //2 = website
            //     "taxid": 6, //----->ถ้าลูกค้าไม่เลือก ให้ใส่ 0
            //     "paymentchannelcode": "2", //----> 2 = บัตรเครดิต 6 = Thai QR 3= โอนเงิน
            //     "map_lattitude": "13.25252545",  
            //     "map_longtitude": "100.7835423",
            //     "orderapprove": "Y", //--------> ถ้าเป็นที่อยู่ใหม่ หรือ paymentchannel ใหใส่เป็น N
            //     "ordremark": "หมายเหตุ",
            //   }
        $data = $request->all();
        //---------------------------------------------------- check empty -------------------------------------//
        // Validate the incoming request data
        $requiredFields = [
            'custid','refmainid', 'addressid', 'branchid', 'contacttel', 'contactname',
            'channelcode',  'taxid','paymentchannelcode',  'orderapprove'
        ];

        // ตรวจสอบฟิลด์ที่ต้องการ
        $validationResult = $this->validateFields($data, $requiredFields);
        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid data',
                'data' => $validationResult['messages'],
            ], 400); // HTTP status 400 คือ Bad Request
        }
        //-------------------------------------- check datetime -------------------------------------------------//
        $dateTimeFields = [
            'orderestimatedate'
        ];
        if($data['orderestimatedate']!=''){
            $validationResult = $this->validateDateTimeFields($data, $dateTimeFields);
            
            if (!$validationResult['isValid']) {
                return response()->json([
                    'status' => 'error',
                    'errormessage' => 'Invalid datetime format',
                    'data' => $validationResult['messages']
                ], 400); // HTTP status 400 คือ Bad Request
            }
        }
        //------------------------------------------check number ----------------------------------------------//
        $numericFields = [
            'custid','refmainid', 'addressid', 'taxid'
        ];

        // ตรวจสอบฟิลด์ที่เป็นตัวเลขทั้งหมดในข้อมูลหลัก
        $validationResult = $this->validateNumericFields($data, $numericFields);

        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid numeric format',
                'data' =>$validationResult['messages']
            ], 400); // HTTP status 400 คือ Bad Request
        }
        //----------------------------------------------------------------------------------------------------//

        // เริ่ม Transaction
        \DB::beginTransaction();
        try {
            // สร้าง Order
            $currentDateTime = DB::select("SELECT NOW() as current_datetime")[0]->current_datetime;
            // Assume these variables are already set
            $next_order_date = $data["orderestimatedate"]; // your next order date input

            // ดึงข้อมูลที่ต้องการทั้งหมดในครั้งเดียว
            $codedescs = CodeDesc::whereIn('groupname', ['DELIVERYCONST', 'CHANNEL', 'PAYMENTCHANNEL'])
            ->whereIn('codename', [
                'PROMISETIME',
                $data['channelcode'],
                $data['paymentchannelcode']
            ])->get()->keyBy(function ($item) {
                return $item->groupname . '-' . $item->codename;
            });
           
            $promisetime = $codedescs['DELIVERYCONST-PROMISETIME']->codevalue ?? null;
            $channelname = $codedescs['CHANNEL-' . $data['channelcode']]->codevalue ?? null;
            $paymentchannel = $codedescs['PAYMENTCHANNEL-' . $data['paymentchannelcode']]->codevalue ?? null;
            $payment_type = $codedescs['PAYMENTCHANNEL-' . $data['paymentchannelcode']]->codevalue8 ?? null;

            //$promisetime = 60; // your promised time in minutes
            if (!empty($next_order_date)) { // advance order
                $timestamp = strtotime(str_replace('/', '-', $next_order_date));
                $new_next_order_date = date("Y-m-d H:i:s", $timestamp);

                $results = DB::select("
                    SELECT 
                        DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AS conf_date,
                        CASE 
                            WHEN TIMESTAMPDIFF(MINUTE, NOW(), ?) < 60 THEN NOW()
                            ELSE DATE_SUB(?, INTERVAL ? MINUTE)
                        END AS ord_start,
                        CASE 
                            WHEN TIMESTAMPDIFF(MINUTE, NOW(), ?) < 60 THEN DATE_ADD(NOW(), INTERVAL 60 MINUTE)
                            ELSE ?
                        END AS ord_rcv
                ", [$new_next_order_date, $new_next_order_date, $promisetime, $new_next_order_date, $new_next_order_date]);

                if ($results) {
                    $ts_ord_start = $results[0]->ord_start;
                    $ts_conf_date = $results[0]->conf_date;
                    $ts_ord_rcv = $results[0]->ord_rcv;
                }
            } else { // now order
                $results = DB::select("
                    SELECT 
                        DATE_ADD(NOW(), INTERVAL ? MINUTE) AS esitimatetime,
                        DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i:%s') AS todaydaytime
                ", [$promisetime]);

                if ($results) {
                    $ts_ord_start = $results[0]->todaydaytime;
                    $ts_conf_date = $results[0]->todaydaytime;
                    $ts_ord_rcv = $results[0]->esitimatetime;
                }
            }
            $branchid = $data['branchid'];
            // ดึงข้อมูล branch
            $branch = Branch::find($branchid);
            $currentDate = now()->format('ym');
            // สร้าง orderidpos และ ordbrno
            $orderidpos = sprintf("%s-%s%05d", $branch->branchcode, $currentDate, $branch->orderid);
            $ordbrno = sprintf("%s/%05d", $branch->branchcode, $branch->orderid);
            $branchname = $branch->name;
            $branchcode = $branch->branchcode;
            // อัปเดต orderid ในตาราง branch
            $branch->orderid += 1;
            $branch->save();

            $customerId = $data['custid'];
            //---------------------------- customer -------------------------------//
            $customer = Customers::where('id', $customerId)->first();
            $custfname=$customer->first_name;
            $custlname=$customer->last_name;
            //     "custfname": "ทดสอบ",
            //     "custlname": "ทดสอบ",
            if ($customer) {
                $customer->update([
                    'lastcontactdate' =>  $currentDateTime,
                    'lastorderdate' =>  $currentDateTime,
                    'ordercount' => DB::raw('ordercount + 1')
                ]);
            }
            //---------------------------------------------------------------------//
            $refmainid=$data['refmainid'];
            $ShoppingCartMain = ZShoppingCartMain::where('refmainid', $refmainid)->first();
            $ordermode = $ShoppingCartMain->order_mode;
            $preamount = $ShoppingCartMain->pre_amount;
            $amount = $ShoppingCartMain->total_amount;
            $totalcustdiscount= $ShoppingCartMain->discount_member;
            $totalpromodiscount=$ShoppingCartMain->discount_promotion;
            $totaldiscountkeyin=$ShoppingCartMain->discount_special;

            // $ordremark=$ShoppingCartMain->discount_message;
            
            // Set order dates
            $data['orddate']= $currentDateTime;
            $data['firstcreateddatetime']= $currentDateTime;
            $data['orderconfirmdate'] = $ts_conf_date;
            $data['orderstartdate'] = $ts_ord_start;
            $data['orderestimatedate'] = $ts_ord_rcv;
            $data['orderstatus'] = '1';
            $data['ordertypestatus'] = '1';
            $data['createduserid'] = '99999996';
            $data['createdname'] = 'Website';
            $data['createddate'] = $currentDateTime;
            $data['firstcreateduserid'] = '99999996';
            $data['firstcreatedname'] = 'Website';
            $data['orderwssuccess'] = 'Y';
            $data['orderwssuccessdate'] = $currentDateTime;
            $data['orderidpos'] = $orderidpos;
            $data['ordbrno'] = $ordbrno;
            $data['channelname'] = $channelname;
            $data['paymentchannel'] = $paymentchannel;
            $data['paymentstatus'] = 'N';
            //-----------------------customer---------------------------------------//
            $data['custfname'] = $custfname;
            $data['custlname'] = $custlname;
            //----------------------------total amount-----------------------------//
            $data['ordermode'] = $ordermode;
            $data['preamount'] = $preamount;
            $data['amount'] = $amount;
            $data['totalcustdiscount'] = $totalcustdiscount;
            $data['totalpromodiscount'] = $totalpromodiscount;
            $data['totaldiscountkeyin'] = $totaldiscountkeyin;
            // Create order
            $order = Order::create($data);
            $reforder = $order->ordno;

            //----------------------------shopping cart--------------------------------------//
            $ShoppingCart = ShoppingCart::where('refmainid', $refmainid)
            ->orderBy('shoppingcartid')
            ->get();
            // ตรวจสอบว่าพบข้อมูล Order หรือไม่
            if ($ShoppingCart->isEmpty()) {
                return response()->json([
                    'status' => 'not success',
                    'errormessage' => 'Shopping Cart not found',
                    'data' =>  []
                ], 403);
            }
        
            $DataItem = [];
            $itemsMap = [];
            $prodmainid='';
            $n=0;
            foreach ($ShoppingCart as $row) {

                if (( $row->item_indexset === 0 || $row->item_indexset === 1 )  && $row->item_setid === null && $row->item_maincode === null) {
                    // เป็นรายการหลัก (item)
                    $item = [
                        'productid' => $row->item_id,
                        'productcode' => $row->item_code,
                        'productname' => $row->item_name,
                        'ordermenuremark' => $row->item_remark,
                        'qty' => $row->item_qty,
                        'unitprice' => $row->item_unitprice,
                        'setflag' => 'Y',
                        'indexset'=> $row->item_setid,
                        'sortsetid' => $row->item_setid,
                        'productgroupid'=> $row->item_productgroupid,
                        'productgroupname' => $row->item_productgroupname,
                        'ordno' => $reforder,
                        'productrun' => $row->item_id,
                        'createduserid'=> '99999996',
                        'createdname' => 'Website',
                        'createddate' => $currentDateTime,
                    ];
                
                    if ($row->item_indexset === 1){
                        $prodmainid = $row->item_code;
                        $modgroup = 'Y';
                      
                    //มี subitems
                    }else{
                        $prodmainid = '';
                        $modgroup = '';
                  
                        //มี ไม่มี
                    }
                    $item['layerid'] = $n;
                    $item['modgroup'] = $modgroup;
                    // เก็บ item ลงในแผนที่เพื่อตรวจสอบ subitems
                    OrderDetail::create($item);
                    $itemsMap[$row->shoppingcartid] = $item;
                   
                } else {
                    // เป็น subitem
                    
                    $subitem = [
                        //'sub_item_no' => $row->item_no,
                        'productid' => $row->item_id,
                        'productcode' => $row->item_code,
                        'productname' => $row->item_name,
                        'ordermenuremark' => $row->item_remark,
                        'qty' => $row->item_qty,
                        'unitprice' => $row->item_unitprice,
                        'indexset'=> $row->item_setid,
                        'sortsetid' => $row->item_setid,
                        'setflag' => 'Y',
                        'productgroupid'=> $row->item_productgroupid,
                        'productgroupname' => $row->item_productgroupname,
                        'prodmainid' => $prodmainid,
                        'ordno' => $reforder,
                        'productrun' => $row->item_id,
                        'createduserid'=> '99999996',
                        'createdname' => 'Website',
                        'createddate' => $currentDateTime,
                        'modgroup'=> 'Y',
                        'layerid' => $n

                    ];
                  
                    OrderDetail::create($subitem);
                    // เพิ่ม subitem ลงใน item ที่เกี่ยวข้อง
                    if (isset($itemsMap[$row->item_setid])) {
                        $itemsMap[$row->item_setid]['subitems'][] = $subitem;
                    }
                }
                $n++;
            }
            if ($ordermode ==='D'){
                //--------------ทำ item ค่าจัดส่ง
                $item_delifee = [
                    'productid' => '999999999',
                    'productcode' => '4779',
                    'productname' => 'ค่าจัดส่ง',
                    'qty' => '1',
                    'unitprice' => '50',
                    'setflag' => 'Y',
                    'productgroupid'=> '99',
                    'productgroupname' => 'ค่าจัดส่ง',
                    'ordno' => $reforder,
                    'createduserid'=> '99999996',
                    'createdname' => 'Website',
                    'createddate' => $currentDateTime,
                    'layerid' => '9999',
                    'productrun' => '999999999'

                ];
                OrderDetail::create($item_delifee);

            }


            // แปลง itemsMap เป็น array ของ items
            foreach ($itemsMap as $item) {
                $DataItem[] = $item;
            }

            $activityData = [
                'ordno' => $reforder,
                'activitydate' => $currentDateTime,
                'activitytype' => '01',
                'activitymessage' => $orderidpos,
                'activitystatus' => 'Y',
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            OrderActivity::create($activityData);
           
            // ##### Service Request ##### //
            $sr = [
                'custid' => $customerId,
                'channelid' => $data['channelcode'],
                'channelcode' => $data['channelcode'],
                'channelname' =>  $channelname,
                'contactphone' => $data['contacttel'],
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            $serviceRequest = ServiceRequest::create($sr);
            // รับค่า srno จากการสร้าง record
            $srno = $serviceRequest->srno; // assuming 'srno' is the primary key and auto-incrementing field in 'tbl_service_request'
            // ##### Ticket ##### //
            $catid = "1";
            $catcode =  "O";
            $catname =  "ออเดอร์";
            $subcatid = "1";
            $subcatcode =  "O01";
            $subcatname =  "ออเดอร์";
            $subcatemail = "N";
            $subcatsms = "N";
            $subcatws = "N";
            if ($data['ordermode']== "P") {
                $cattypeid = "2";
                $cattypename = "รับเองที่สาขา";
            } else {
                $cattypeid = "1";
                $cattypename = "จัดส่ง";
            }
            $ticketdetail = "New Order";
            $ticketsolution = "";  
            $ticketstatusid	 = "8";
            $ticketstatuscode = "C";
            $ticketstatusname = "ดำเนินการเรียบร้อย";
            $ticketstatustype = "C";
            $ticketstatussms = "N";
            $ticketstatusemail = "N";
            $ticketstatusspecial = "N";
            $firstcallresolution = "N";
            $ticketattachfile = "0";
            $ticketData = [
                'srno' => $srno,
                'custid' => $customerId,
                'catid' => $catid,
                'catcode' => $catcode,
                'catname' => $catname,
                'subcatid' => $subcatid,
                'subcatcode' => $subcatcode,
                'subcatname' => $subcatname,
                'subcatsms' => $subcatsms,
                'subcatemail' => $subcatemail,
                'subcatws' => $subcatws,
                'ticketdetail' => $ticketdetail,
                'ticketsolution' => $ticketsolution,
                'ticketstatusid' => $ticketstatusid,
                'ticketstatuscode' => $ticketstatuscode,
                'ticketstatusname' => $ticketstatusname,
                'ticketstatustype' => $ticketstatustype,
                'ticketstatussms' => $ticketstatussms,
                'ticketstatusemail' => $ticketstatusemail,
                'firstcallresolution' => $firstcallresolution,
                'ticketattachfile' => $ticketattachfile,
                'cattypeid' => $cattypeid,
                'cattypename' => $cattypename,
                'branchid' => $branchid,
                'branchcode' => $branchcode,
                'branchname' => $branchname,
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            if ($ticketstatuscode == "C") {
                $ticketData['closeduserid'] = '99999996';
                $ticketData['closedname'] = 'Website';
                $ticketData['closeddate'] = $currentDateTime;
            }
            //---------------------------------------------------//
            // สร้าง record ใหม่ในตาราง tbl_service_ticket
            $ServiceTicket = ServiceTicket::create($ticketData);
            $ticketid = $ServiceTicket->ticketid;
            // ##### Ticket Log ##### //
            $ticketLogData = [
                'ticketid' => $ticketid,
                'srno' => $srno,
                'custid' => $customerId,
                'ticketworklog' => $ticketsolution,
                'ticketstatusid' => $ticketstatusid,
                'ticketstatuscode' => $ticketstatuscode,
                'ticketstatusname' => $ticketstatusname,
                'ticketstatustype' => $ticketstatustype,
                'ticketstatussms' => $ticketstatussms,
                'ticketstatusemail' => $ticketstatusemail,
                'createduserid' => '99999996',
                'createdname' => 'Website',
                'createddate' => $currentDateTime,
            ];
            // สร้าง record ใหม่ในตาราง tbl_service_ticket_log
            $serviceTicketLog = ServiceTicketLog::create($ticketLogData);
            // รับค่า ticketlogid จากการสร้าง record
            $ticketlogid = $serviceTicketLog->ticketlogid;
           
            //-----------------call getpaymentlink --------------------------//
            if  ($payment_type === 'PAY'){
                $payOrderController = new PayOrderController();
                $payresponse = $payOrderController->linkpayorder($reforder);
                $responseData = json_decode($payresponse->getContent(), true);
                // ทำงานกับ responseData
                if ($responseData['status'] === 'success') {
                    $paylink = $responseData['data'];
                } else {
                    $paylink="";
                }
            }else{
                $paylink="";
            }
            //--------------------get order----------------------------------//
            $ordresponse =  $this->getorder($request,$reforder);
            $responseOrd = json_decode($ordresponse->getContent(), true);
            if ($responseOrd['status'] === 'success') {
                $OrderData = $responseOrd['data'];
                $OrderData['paymentlink']=$paylink;
            } else {
                $OrderData="";
            }
            //---------------------------------------------------------------//
             // Commit Transaction
            \DB::commit();
            
            $responseData = [
                'status' => 'success',
                'errormessage' => '',
                'data' => $OrderData
            ];
            return response()->json($responseData, 201, [], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            // Rollback Transaction
            \DB::rollBack();

            return response()->json([
                'status' => 'error',
                'errormessage' => $e->getMessage(),
                'data' => $e->getMessage()
            ], 500);
        }
    }


    public function shoppingcrt(Request $request)
    {
       
        // ระบุฟิลด์ที่ต้องการตรวจสอบ
        $data = $request->all();
        $requiredFields = [
            'custid',  'order_mode',
        ];

       
        // ตรวจสอบฟิลด์ที่ต้องการ
        $validationResult = $this->validateFields($data, $requiredFields);
        
        if (!$validationResult['isValid']) {
            return response()->json([
                'error' => 'Invalid data',
                'messages' => $validationResult['messages'],
            ], 400); // HTTP status 400 คือ Bad Request
        }

        // ตรวจสอบฟิลด์ใน items
        if (isset($data['items'])) {
            foreach ($data['items'] as $index => $item) {
                $itemRequiredFields = [
                    'item_no', 'item_id', 'item_code', 'item_name', 'item_remark',
                    'item_qty', 'item_unitprice', 'item_indexset',
                ];

                $itemValidationResult = $this->validateFields($item, $itemRequiredFields, 'items.' . $index);

                if (!$itemValidationResult['isValid']) {
                    return response()->json([
                        'error' => 'Invalid data in items',
                        'messages' => $itemValidationResult['messages'],
                    ], 400); // HTTP status 400 คือ Bad Request
                }

                // ตรวจสอบฟิลด์ใน subitems
                if (isset($item['subitems'])) {
                    foreach ($item['subitems'] as $subIndex => $subitem) {
                        $subitemRequiredFields = [
                            'sub_item_no', 'sub_item_id', 'sub_item_code', 'sub_item_name',
                            'sub_item_remark', 'sub_item_qty', 'sub_item_unitprice',
                        ];

                        $subitemValidationResult = $this->validateFields($subitem, $subitemRequiredFields, 'items.' . $index . '.subitems.' . $subIndex);

                        if (!$subitemValidationResult['isValid']) {
                            return response()->json([
                                'error' => 'Invalid data in subitems',
                                'messages' => $subitemValidationResult['messages'],
                            ], 400); // HTTP status 400 คือ Bad Request
                        }
                    }
                }

            }
        }

        //------------------------------------------check number ----------------------------------------------//
        $numericFields = [
        'custid'
        ];

        $validationResult = $this->validateNumericFields($data, $numericFields);

        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid numeric format',
                'data' =>$validationResult['messages']
            ], 400); // HTTP status 400 คือ Bad Request
        }
        // ตรวจสอบฟิลด์ใน items number
        if (isset($data['items'])) {
            foreach ($data['items'] as $index => $item) {
                $itemNumericFields = [
                    'sub_item_qty', 'sub_item_unitprice'
                ];

                $itemValidationResult = $this->validateNumericFields($item, $itemNumericFields, 'items.' . $index);

                if (!$itemValidationResult['isValid']) {
                    return response()->json([
                        'error' => 'Invalid numeric format',
                        'messages' => $itemValidationResult['messages'],
                    ], 400); // HTTP status 400 คือ Bad Request
                }

                // ตรวจสอบฟิลด์ใน subitems number
                if (isset($item['subitems'])) {
                    foreach ($item['subitems'] as $subIndex => $subitem) {
                        $subitemNumericFields = [
                            'sub_item_qty', 'sub_item_unitprice'
                        ];

                        $subitemValidationResult = $this->validateNumericFields($subitem, $subitemNumericFields, 'items.' . $index . '.subitems.' . $subIndex);

                        if (!$subitemValidationResult['isValid']) {
                            return response()->json([
                                'error' => 'Invalid numeric format',
                                'messages' => $subitemValidationResult['messages'],
                            ], 400); // HTTP status 400 คือ Bad Request
                        }
                    }
                }

            }
        }
       
        //------------------------------------------check limit 1 ----------------------------------------------//
        $limiti1cFields = [
            'order_mode' //----->'"is_active"'
        ];

        $validationResult = $this->validateLimit1($data, $limiti1cFields);
        if (!$validationResult['isValid']) {
            return response()->json([
                'status' => 'error',
                'errormessage' => 'Invalid data not must',
                'data' =>$validationResult['messages']
            ], 400); // HTTP status 400 คือ Bad Request
        }
        // ตรวจสอบฟิลด์ใน items number
        if (isset($data['items'])) {
            foreach ($data['items'] as $index => $item) {
                $itemLimiti1Fields = [
                    'item_indexset'
                ];

                $itemValidationResult = $this->validateLimit1($item, $itemLimiti1Fields, 'items.' . $index);

                if (!$itemValidationResult['isValid']) {
                    return response()->json([
                        'error' => 'Invalid data not must',
                        'messages' => $itemValidationResult['messages'],
                    ], 400); // HTTP status 400 คือ Bad Request
                }
            }
        }
        $custid = $data['custid'];
        $order_mode=$data['order_mode'];
       //-----------------------seve data ----------------------------//

        $customer = Customers::where('id', $custid)->first();
        if (!$customer) {
            // Handle the case where the customer is not found
            return response()->json([
                'error' => 'customer not data',
                'messages' => 'Invalid data in customer',
            ], 400); // HTTP 'customer not data'
        }
       $currentDateTime = DB::select("SELECT NOW() as current_datetime")[0]->current_datetime;

       $MudjaiController = new MudjaiController();
       $memberid='N';
       if (empty($customer->mudjaimemberid)) {
           $mudjairesponse = $MudjaiController->mudjaimemberphone($customer->phone_number);
           
       } else {
           $mudjairesponse = $MudjaiController->mudjaimemberid($customer->mudjaimemberid);
           $memberid='Y';
       }
        // v1/mudjai/mudjaimemberid/SNP202211-M0187149
        $responseData = json_decode($mudjairesponse->getContent(), true);
        if (isset($responseData['error']) && !empty($responseData['error']) && $memberid === 'Y') {
            $mudjairesponse = $MudjaiController->mudjaimemberphone($customer->phone_number);
            $responseData = json_decode($mudjairesponse->getContent(), true);
            $memberid='Y2';
        }
        if (isset($responseData['error']) && !empty($responseData['error']) && $memberid === 'Y2') {
            $mudjairesponse = $MudjaiController->mudjaimemberphone($customer->mudjaimemberphone);
            $responseData = json_decode($mudjairesponse->getContent(), true);
        }

        if (!isset($responseData['error'])) {
            $mudjaimemberid = $responseData["memberID"] ?? null;
            $mudjaimemberphone = $responseData["phone"] ?? null;
            $mudjaimemberbirth = $responseData["dateOfBirth"] ?? null;
            $mudjaimemberpoint = $responseData["totalPoints"] ?? null;
            $mudjaimemberactive = $responseData["isSubscriptionActive"] ?? null;
            $mudjaimemberexpire = $responseData["subscriptionEndDate"] ?? null;
            $customer->update([
                'mudjailastcheckdate' => Carbon::now(),
                'mudjaimemberid' => $mudjaimemberid,
                'mudjaimemberphone' => $mudjaimemberphone,
                'mudjaimemberbirth' => $mudjaimemberbirth,
                'mudjaimemberpoint' => $mudjaimemberpoint,
                'mudjaimemberactive' => $mudjaimemberactive,
                'mudjaimemberexpire' => $mudjaimemberexpire
            ]);

            // Get the updated customer instance
            $customer = $customer->fresh();
            $mudjaistatus = "Y";
            $mudjaidata = $mudjairesponse->getContent();

            if ($customer->mudjaimemberid !=''){
                $monthbirth = null;
                $activebirth = 0;
                if ($customer->mudjaimemberbirth) {
                    $birthDate = new DateTime($customer->mudjaimemberbirth);
                    $monthbirth = $birthDate->format('m');
                }
                $currentDate = new DateTime($currentDateTime);
                $month = $currentDate->format('m');
                
                if ($monthbirth && $monthbirth == $month) {
                    $activebirth = 1;
                }

                $member = [
                    "id"=>$customer->mudjaimemberid,
                    "phone"=>$customer->mudjaimemberphone,
                    "point"=>$customer->mudjaimemberpoint,
                    "is_active"=>$customer->mudjaimemberactive,
                    "is_birth"=>$activebirth,
                    "expired"=>$customer->mudjaimemberexpire,
                ];

                $is_member='1';

            }else{

                $member = [];
                $is_member='0';

            }
            
        }else{
            
            if ($customer->mudjaimemberid !=''){
                $monthbirth = null;
                $activebirth = 0;
                if ($customer->mudjaimemberbirth) {
                    $birthDate = new DateTime($customer->mudjaimemberbirth);
                    $monthbirth = $birthDate->format('m');
                }
                $currentDate = new DateTime($currentDateTime);
                $month = $currentDate->format('m');
                
                if ($monthbirth && $monthbirth == $month) {
                    $activebirth = 1;
                }

                $member = [
                    "id"=>$customer->mudjaimemberid,
                    "phone"=>$customer->mudjaimemberphone,
                    "point"=>$customer->mudjaimemberpoint,
                    "is_active"=>$customer->mudjaimemberactive,
                    "is_birth"=>$activebirth,
                    "expired"=>$customer->mudjaimemberexpire,
                ];

                $is_member='1';

            }else{

                $member = [];
                $is_member='0';

            }
        } 

        if (isset($responseData['error']) && !empty($responseData['error'])) {
           //log ws
           $mudjaistatus = "N";
           $wslogresponse = $responseData['error'];
           $mudjaidata = $wslogresponse;
        }

        








       $insertcartmain =  [
        'custid' => $custid ,
        'is_member' => '0',
        'order_mode' => $order_mode,
        'createddate' =>  $currentDateTime,
        'modifieddate'=>$currentDateTime,
        "deli_fee"=>0,
        "subtotal_amount"=>0,
        "total_amount"=>0,
        "is_active"=>'N',
        "discount_member"=>0,
        "discount_promotion"=>0,
        "discount_special"=>0,
        'pre_amount'=>0,
        "discount_message"=> '',
        "earnest"=>0
       ];
       $shoppingCartMainRequest = ZShoppingCartMain::create($insertcartmain);
        $refmainid = $shoppingCartMainRequest->refmainid;
        // บันทึกข้อมูล items และ subitems
        foreach ($data['items'] as $item) {
            $itemData = [
                'refmainid'  => $refmainid,
                'item_no' => $item['item_no'],
                'item_id' => $item['item_id'],
                'item_code' => $item['item_code'],
                'item_name' => $item['item_name'],
                'item_remark' => $item['item_remark'],
                'item_qty' => $item['item_qty'],
                'item_unitprice' => $item['item_unitprice'],
                'item_indexset' => $item['item_indexset'],
                'createddate' =>  $currentDateTime,
                'item_mainid'=> $item['item_no'],
                'item_setid' => null,
                'item_maincode' => null
            ];
            $shoppingCartRequest = ShoppingCart::create($itemData);
            $item_setid = $shoppingCartRequest->shoppingcartid;
            if (isset($item['subitems'])) {
                foreach ($item['subitems'] as $subitem) {
                    $subitemData = array_merge($itemData, [
                        'item_no' => $subitem['sub_item_no'],
                        'item_id' => $subitem['sub_item_id'],
                        'item_code' => $subitem['sub_item_code'],
                        'item_name' => $subitem['sub_item_name'],
                        'item_remark' => $subitem['sub_item_remark'],
                        'item_qty' => $subitem['sub_item_qty'],
                        'item_unitprice' => $subitem['sub_item_unitprice'],
                        'item_setid' => $item_setid,
                        'item_mainid'=> $item['item_no'],
                        'item_maincode' => $item['item_code'],
                        'item_indexset' => null,
                        'createddate' =>  $currentDateTime
                    ]);
                    ShoppingCart::create($subitemData);
                }
            }
        }
       //---------------------------- คำนวน pay total -----------------------//
       

        $delifee=0;
        $subtotal=0;
        $discount_member=0;
        $discount_promotion=0;
        $discount_special=0;
        $discount_message="";
        $earnest=0;
        $nettotal=0;
       
        if ($order_mode==='D'){
            $delifee=50; 
        }
        // กรณีมี memberid 
        // curl --location 'https://dev.mudjaicrm.com/snp_uat_api/api/member/SNP202211-M0187149' \
        // --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6bnVsbCwic3RhZmZDb2RlIjoiTUowMDAxIiwiZW1wTm8iOm51bGwsInVzZXJHcm91cENvZGUiOiJVRzAwMSIsInVzZXJSb2xlQ29kZSI6IlJPMDAxIiwidXNlckNvZGUiOiJNSjAwMDEiLCJ1c2VyVHlwZUNvZGUiOm51bGwsInVzZXJDaGlsZExpc3QiOltdLCJ1c2VyVHlwZUlkIjowLCJ1c2VyTmFtZSI6ImFkbWluIiwibmFtZSI6ImFkbWluIiwiaXNBY3RpdmUiOiJZIiwidG9rZW5EYXRlVGltZSI6MTcyMDAyMTIzNCwiaXNMb2dvdXQiOm51bGwsInVzZXJDaGFubmVsIjoiTUoiLCJhcGlLZXlMaXN0IjpbXX0.hTTAytt6KbeQnqEvSEmD8xSp8qwKEtlUiMvCNPCmef8'

        //ไม่มี memberid
        // curl --location 'https://dev.mudjaicrm.com/snp_uat_api/api/member/lookupByAttributes' \
        // --header 'Content-Type: application/json' \
        // --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6bnVsbCwic3RhZmZDb2RlIjoiTUowMDAxIiwiZW1wTm8iOm51bGwsInVzZXJHcm91cENvZGUiOiJVRzAwMSIsInVzZXJSb2xlQ29kZSI6IlJPMDAxIiwidXNlckNvZGUiOiJNSjAwMDEiLCJ1c2VyVHlwZUNvZGUiOm51bGwsInVzZXJDaGlsZExpc3QiOltdLCJ1c2VyVHlwZUlkIjowLCJ1c2VyTmFtZSI6ImFkbWluIiwibmFtZSI6ImFkbWluIiwiaXNBY3RpdmUiOiJZIiwidG9rZW5EYXRlVGltZSI6MTcyMDAyMTIzNCwiaXNMb2dvdXQiOm51bGwsInVzZXJDaGFubmVsIjoiTUoiLCJhcGlLZXlMaXN0IjpbXX0.hTTAytt6KbeQnqEvSEmD8xSp8qwKEtlUiMvCNPCmef8' \
        // --data '{
        //     "phone" : "0910000002"
        // }'
        //------------------เรียก api rrr ใช้ custid เบอร์โทร ----------//
        //------------update ลง customer ---------------------------//
        //----------------------------------------------------------//
     
        

      


       // mudjailastcheckdate 
       //mudjaimemberexpire

       
        $ShoppingCart = ShoppingCart::where('refmainid', $refmainid)
            ->orderBy('shoppingcartid')
        ->get();
        // ตรวจสอบว่าพบข้อมูล Order หรือไม่
        if ($ShoppingCart->isEmpty()) {
            return response()->json([
                'status' => 'not success',
                'errormessage' => 'Shopping Cart not found',
                'data' =>  []
            ], 403);
        }
        
        $DataItem = [];
        $itemsMap = [];

        foreach ($ShoppingCart as $row) {


            if (( $row->item_indexset === 0 || $row->item_indexset === 1 )  && $row->item_setid === null && $row->item_maincode === null) {
                // เป็นรายการหลัก (item)
                $item = [
                    'item_no' => $row->item_no,
                    'item_id' => $row->item_id,
                    'item_code' => $row->item_code,
                    'item_name' => $row->item_name,
                    'item_remark' => $row->item_remark,
                    'item_qty' => $row->item_qty,
                    'item_unitprice' => $row->item_unitprice,
                    'item_indexset' => $row->item_indexset,
                    'subitems' => []
                ];
               
             
                //------------------ getpromosion ------------------------//
                    $subtotal += ($row->item_unitprice*$row->item_qty);
                    //$menu = Menu::where('sku', $row->item_code)->first();
                    $menu = Menu::select([
                        'menu.sku AS productcode',
                        'menu.name AS productname',
                        'menu.before_sale_price AS productprice',
                        'menu.is_active AS productstatus',
                        DB::raw('CASE WHEN menu.type = "set" THEN "Y" ELSE "N" END AS changeinsetflag'),
                        DB::raw('(menu.before_sale_price - menu.price) AS pricediscount'),
                        DB::raw('CASE WHEN menu.price <> menu.before_sale_price THEN "Y" ELSE "N" END AS pricediscountflag'),
                        DB::raw('menu.before_sale_price - (menu.before_sale_price - menu.price) AS pricediscounttrue'),
                        'pg.productgroupid',
                        'pg.productgroupname'
                    ])
                    ->leftJoin('bor_plu as bp', 'bp.code', '=', 'menu.sku')
                    ->leftJoin('tbl_product_group as pg', 'pg.deptcode', '=', 'bp.product_group_code')
                    ->where('menu.sku', $row->item_code)
                    ->first();
                    // $menu = Menu::select([
                    //     'sku as productcode',
                    //     'name as productname',
                    //     DB::raw('1 as productgroupid'),//-----------------ดึงค่า productgroupid จาก table
                    //     DB::raw('"grouptest" as productgroupname'),//-----------------ดึงค่า productgroupname จาก table
                    //     'before_sale_price as productprice',
                    //     'is_active as productstatus',
                    //     DB::raw("(case when type = 'set' then 'Y' else 'N' end) as changeinsetflag"),
                    //     DB::raw("(before_sale_price - price) as pricediscount"),
                    //     DB::raw("(case when price <> before_sale_price then 'Y' else 'N' end) as pricediscountflag"),
                    //     DB::raw("(before_sale_price - (before_sale_price - price)) AS pricediscounttrue")
                    // ])->where('sku', $row->item_code)->first();

                    if ($menu) {
                        $item_productgroupid = $menu->productgroupid;
                        $item_productgroupname = $menu->productgroupname;

                        ShoppingCart::where('refmainid', $refmainid)->update([
                            'item_productgroupid' => $item_productgroupid,
                            'item_productgroupname' => $item_productgroupname,
                        ]);

                        if (!empty($row->item_maincode)) { 
                            $productprice = 0 ;
                        } else {
                            $productprice = $menu->productprice;
                        }				
                        //$flagcustdiscount = $rowproduct["flagcustdiscount"];					
                        //$flagsetcustdiscount = $rowproduct["flagsetcustdiscount"];					
                        $pricediscount = $menu->pricediscount;			
                        $pricediscountflag	= $menu->pricediscountflag;	
                        if ($pricediscount > 0 && $pricediscountflag == "Y" && $productprice > 0) {
                            //$discount_promotion = $discount_promotion + ($pricediscount*$row->item_qty);												
                            $discount_promotion += ($pricediscount * $row->item_qty);
                            
                        }	


                        $BorPmMemberHasPlu = BorPmMemberHasPlu::join('bor_plu as p', 'p.id', '=', 'bor_pm_member_has_plu.plu_id')
                        ->join('bor_pm_member as pm', 'pm.id', '=', 'bor_pm_member_has_plu.pm_member_id')
                        ->select('pm.id')
                        ->where('p.code', $menu->productcode)
                        ->where('pm.pro_code', '10MEM')
                        ->get();
                        if ($BorPmMemberHasPlu->isNotEmpty()) {
                            $hasplu = "Y";
                        } else {
                            $hasplu = "N";
                        }

                        if ($customer->mudjaimemberactive===1){
                            if ($hasplu == "Y" && $productprice > 0) {
                            $discount_member += ceil((($productprice * $row->item_qty)*10)/100);
                            
                        }
                     


                        // //##### update discount price into shpping cart 20240719 #####
                        //     $sqlud = "update z_shopping_cart set discountprice = '".$totalflagcustdiscount."',discounttype = 'P' ";
                        //     $sqlud .= " where indexid = '".$rowscart["indexid"]."' ";
                        //     mysqli_query($conn , $sqlud) or die('Error, query failed : ' . mysqli_error($conn) . ' -> ' . $sqlud);
                        // //##### update discount price into shpping cart 20240719 #####
                    }





                    }
                //------------------------------------------------------//
                // เก็บ item ลงในแผนที่เพื่อตรวจสอบ subitems
                $itemsMap[$row->shoppingcartid] = $item;
            } else {
                // เป็น subitem
                $subitem = [
                    'sub_item_no' => $row->item_no,
                    'sub_item_id' => $row->item_id,
                    'sub_item_code' => $row->item_code,
                    'sub_item_name' => $row->item_name,
                    'sub_item_remark' => $row->item_remark,
                    'sub_item_qty' => $row->item_qty,
                    'sub_item_unitprice' => $row->item_unitprice
                ];

                // เพิ่ม subitem ลงใน item ที่เกี่ยวข้อง
                if (isset($itemsMap[$row->item_setid])) {
                    $itemsMap[$row->item_setid]['subitems'][] = $subitem;
                }
            }
        }
        // แปลง itemsMap เป็น array ของ items
        foreach ($itemsMap as $item) {
            $DataItem[] = $item;
        }

        $nettotal=($delifee+(((($subtotal - $discount_promotion)-$discount_member)-$discount_special)));
       
        $amounts = [
            "subtotal"=>$subtotal,
            "discount_member"=>$discount_member,
            "discount_promotion"=>$discount_promotion,
            "discount_special"=>$discount_special,
            "discount_message"=> substr($discount_message, 0, 100),
            "earnest"=>$earnest
        ];
      
        $modifieDateTime = DB::select("SELECT NOW() as current_datetime")[0]->current_datetime;
        // Update or create the record in the z_shopping_cart_main table
      
        $updatehoppingCartMain = ZShoppingCartMain::where('refmainid', $refmainid)->first();
        if ($updatehoppingCartMain) {
            $updatehoppingCartMain->update([
                "deli_fee"=>$delifee,
                "pre_amount"=>$subtotal,
                "total_amount"=>$nettotal,
                "is_active"=>'Y',
                'is_member' => $is_member,
                "discount_member"=>$discount_member,
                "discount_promotion"=>$discount_promotion,
                "discount_special"=>$discount_special,
                "discount_message"=> substr($discount_message, 0, 100),
                "earnest"=>$earnest
            ]);
        }
        $amounts["delifee"] = $delifee;
        $amounts["nettotal"] = $nettotal;
        $DataShopping = [
            'refmainid' => $refmainid,
            'custid' => $custid,
            'order_mode' => $order_mode,
            'items' => $DataItem,
            'member'=>$member,
            "amounts"=>$amounts,
            'modifieddate'=>$modifieDateTime

        ];

       //---------------------------------------------------------------------// 
      
      






       //-------------------------------------------------------------//










        $responseData = [
            'status' => 'success',
            'errormessage' => '',
            'data' => $DataShopping
        ];

        return response()->json($responseData, 200, [], JSON_UNESCAPED_UNICODE);

    }






}






