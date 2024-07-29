<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait PayOrderTrait
{

    
    

    



    public function ChargeApi($data, $urlcharge, $skey)
    {
        $client = new Client();

        try {
            $response = $client->post($urlcharge, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-key' => $skey
                ],
                'json' => $data,
                'verify' => false // ปิดการตรวจสอบ SSL (หากต้องการ)
            ]);

            $responseData = json_decode($response->getBody(), true);
            $httpcode = $response->getStatusCode();

            return [
                'httpcode' => $httpcode,
                'responseData' => $responseData
            ];

        } catch (\Exception $e) {
            return [
                'error' => "Guzzle Error: " . $e->getMessage()
            ];
        }
    }
    
    public function getOrderQr($urlservice, $amount, $description, $reference_order, $skey)
    {
        $url = $urlservice . '/qr/v2/order';
        $data = [
            'amount' => $amount,
            'currency' => 'THB',
            'description' => $description,
            'source_type' => 'qr',
            'reference_order' => $reference_order
        ];
        
        $headers = [
            'Content-Type' => 'application/json',
            'x-api-key' => $skey
        ];
        
        $client = new Client();
        
        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'json' => $data,
                'verify' => false  // ปิดการตรวจสอบ SSL (หากต้องการ)
            ]);
        
            $decodedResponse = json_decode($response->getBody(), true);
            return $decodedResponse;
           
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $decodedResponse = json_decode($response->getBody(), true);

            if ($decodedResponse['code'] === 'ref_order_already_exist') {
                // Handle the specific error
                return [
                    'status' => 'error',
                    'message' => 'Reference order already exist'
                ];
            } else {
                // Handle other errors
                return [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}