<?php
namespace App\Services;

use League\OAuth2\Client\Provider\GenericProvider;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Storage;

class MailService
{
    protected $provider;
    protected $token;

    public function __construct()
    {
        $this->provider = new GenericProvider([
            'clientId'                => env('OAUTH_CLIENT_ID'),
            'clientSecret'            => env('OAUTH_CLIENT_SECRET'),
            'redirectUri'             => 'https://your-redirect-uri',
            'urlAuthorize'            => 'https://login.microsoftonline.com/' . env('OAUTH_TENANT_ID') . '/oauth2/v2.0/authorize',
            'urlAccessToken'          => 'https://login.microsoftonline.com/' . env('OAUTH_TENANT_ID') . '/oauth2/v2.0/token',
            'urlResourceOwnerDetails' => 'https://graph.microsoft.com/v1.0/me'
        ]);

        $this->token = $this->provider->getAccessToken('client_credentials', [
            'scope' => 'https://graph.microsoft.com/.default'
        ]);
    }

    public function sendEmail($from, $to, $subject, $body, $attachmentPath = null)
    {
        // Create the Email object
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->text($body); // ใช้ text() สำหรับ plain text หรือ html() สำหรับ HTML content

        if ($attachmentPath) {
            $email->attachFromPath(Storage::path($attachmentPath));
        }

        // Create the Transport with OAuth2 token
        $transport = new EsmtpTransport('smtp.office365.com', 587);
        $transport->setUsername($from);
        $transport->setPassword($this->token->getToken());
        
        $mailer = new Mailer($transport);

        // Send the Email
        $mailer->send($email);

        return 'Message has been sent';
    }
}