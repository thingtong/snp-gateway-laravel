<?php
namespace App\Http\Controllers\API\v1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MailService;

class EmailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
        ]);

        $to = $request->to;
        $subject = $request->subject;
        $body = $request->body;
        $attachmentPath = $request->file('attachment') ? $request->file('attachment')->store('attachments') : null;

        $result = $this->mailService->sendEmail('touchdeli@true-touch.co.th', $to, $subject, $body, $attachmentPath);

        return response()->json(['message' => 'Email sent successfully.']);
    }
}