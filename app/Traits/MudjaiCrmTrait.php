<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait MudjaiCrmTrait
{
    public function searchMember($query)
    {
        $client = new Client();
        
        $mudjai = env('MUDJAI_TOKEN');
        try {
            $response = $client->post('https://dev.mudjaicrm.com/snp_uat_api/api/member/search', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$mudjai,
                ],
                'json' => [
                    'query' => $query,
                ],
            ]);

            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (\Exception $e) {
            // Handle exceptions here
            return ['error' => $e->getMessage()];
        }
    }

    public function searchMemberId($memberid)
    {
        $client = new Client();
        $mudjai = env('MUDJAI_TOKEN');
        try {
            $response = $client->get('https://dev.mudjaicrm.com/snp_uat_api/api/member/'.$memberid, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$mudjai,
                ]
                
            ]);
            $data = $response->getBody()->getContents();
            return json_decode($data, true);
        } catch (\Exception $e) {
            // Handle exceptions here
            return ['error' => $e->getMessage()];
        }
    }

    public function searchMemberPhone($phone)
    {
        $client = new Client();
        $mudjai = env('MUDJAI_TOKEN');
        try {
            $response = $client->post('https://dev.mudjaicrm.com/snp_uat_api/api/member/lookupByAttributes', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$mudjai,
                ],
                'json' => [
                    'phone' => $phone,
                ],
                
            ]);
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the 'members' key exists and assign it to $data
            if (isset($responseData['members']) && !empty($responseData['members'])) {
                $data = $data['members'][0];
            } else {
                $data = $data['members'][0];
            }

            return $data;
           
        } catch (\Exception $e) {
            // Handle exceptions here
            return ['error' => $e->getMessage()];
        }
    }

}
