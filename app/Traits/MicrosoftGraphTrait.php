<?php
namespace App\Traits;

use GuzzleHttp\Client;
use Microsoft\Graph\Graph;

trait MicrosoftGraphTrait
{
    protected $tenantId;
    protected $clientId;
    protected $clientSecret;
    protected $accessToken;

    public function initializeMicrosoftGraph()
    {
        $this->tenantId = env('MICROSOFT_TENANT_ID');
        $this->clientId = env('MICROSOFT_CLIENT_ID');
        $this->clientSecret = env('MICROSOFT_CLIENT_SECRET');
        $this->authenticate();
    }

    protected function authenticate()
    {
        $url = 'https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token';

        $client = new Client();

        $response = $client->post($url, [
            'form_params' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ],
        ]);

        $body = json_decode((string) $response->getBody(), true);
        $this->accessToken = $body['access_token'];
    }

    public function sendEmailxxx($subject, $body, $to, $attachmentPath = null)
    {
        $graph = new Graph();
        $graph->setAccessToken($this->accessToken);

        $message = [
            "message" => [
                "subject" => $subject,
                "body" => [
                    "contentType" => "Text",
                    "content" => $body
                ],
                "toRecipients" => [
                    [
                        "emailAddress" => [
                            "address" => $to
                        ]
                    ]
                ]
            ]
        ];

        if ($attachmentPath) {
            $attachment = file_get_contents($attachmentPath);
            $attachmentContent = base64_encode($attachment);
            $message['message']['attachments'] = [
                [
                    '@odata.type' => '#microsoft.graph.fileAttachment',
                    'name' => basename($attachmentPath),
                    'contentBytes' => $attachmentContent
                ]
            ];
        }

        $graph->createRequest("POST", "/users/touchdeli@true-touch.co.th/sendMail")
              ->attachBody($message)
              ->execute();
    }
}
