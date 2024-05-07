<?php
namespace App\Service;

use HTTP_Request2_Exception;
use HTTP_Request2;

class SmsService
{
    public function sendSms(string $phoneNumber, string $message): void
    {
        $request = new HTTP_Request2();
        $request->setUrl('https://y3g51d.api.infobip.com/sms/2/text/advanced');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(['follow_redirects' => true]);
        $request->setHeader([
            'Authorization' => 'App f535aac31453317379ba47f3569b80ed-7a35e26d-4617-4131-ae5b-0d767eb103dd',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);
        $request->setBody(json_encode([
            'messages' => [
                [
                    'destinations' => [['to' => $phoneNumber]],
                    'from' => 'ServiceSMS',
                    'text' => $message
                ]
            ]
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() != 200) {
                throw new \RuntimeException('Failed to send SMS: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            throw new \RuntimeException('Error sending SMS: ' . $e->getMessage());
        }
    }
}
