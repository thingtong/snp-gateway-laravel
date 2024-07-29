<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MudjaiCrmTrait;
use GuzzleHttp\Client;
class MudjaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use MudjaiCrmTrait;

    public function mudjaicrm($query)
    {
        //$phoneNumber = '0818129876'; // Example phone number
        $response = $this->searchMember($query);
         return response()->json($response);
    }
    public function mudjaimemberid($memberid)
    {
        //$memberid = 'SNP202211-M0187149'; // Example member id
        $response = $this->searchMemberId($memberid);
         return response()->json($response);
    }
    public function mudjaimemberphone($phone)
    {
        //$phoneNumber = '0910000002'; // Example phone number
        $response = $this->searchMemberPhone($phone);
        return response()->json($response);
    }
}
