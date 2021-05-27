<?php

namespace inquid\firebase;

use Exception;
use GuzzleHttp\Client;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * @author Amr Alshroof
 * Implementation Inquid LLC
 */
class FirebaseNotifications extends BaseObject
{
    /**
     * @var string the auth_key Firebase cloude messageing server key.
     */
    public $authKey;

    public $timeout = 5;
    public $sslVerifyHost = false;
    public $sslVerifyPeer = false;

    /**
     * @var string the api_url for Firebase cloude messageing.
     */
    public $apiUrl = 'https://fcm.googleapis.com/fcm/send';

    public function init()
    {
        if (!$this->authKey) throw new Exception("Empty authKey");
    }

    /**
     * send raw body to FCM
     * @param array $body
     * @return mixed
     */
    public function send($body)
    {
        $headers = [
            "Authorization" => "key={$this->authKey}",
            "Content-Type" => "application/json",
        ];

        try {
            $client = new Client();
            $request = $client->post($this->apiUrl, [
                'headers' => $headers,
                'body' => json_encode($body),
            ]);
            $response = $request->getBody();
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
        }

        return $response;
    }

    /**
     * high level method to send notification for a specific tokens (registration_ids) with FCM
     * see https://firebase.google.com/docs/cloud-messaging/http-server-ref
     * see https://firebase.google.com/docs/cloud-messaging/concept-options#notifications_and_data_messages
     *
     * @param array $tokens the registration ids
     * @param array $notification can be something like {title:, body:, sound:, badge:, click_action:, }
     * @param array $options other FCM options https://firebase.google.com/docs/cloud-messaging/http-server-ref#downstream-http-messages-json
     * @return mixed
     */
    public function sendNotification($notification, $tokens = [])
    {
        $body = [
            'registration_ids' => $tokens,
            'content_available' => true,
            'priority' => 'high'
        ];

        if (isset($notification['to'])) {
            $notification['to'] = '/topics/' . $notification['to'];
            unset($body['registration_ids']);
        }

        $body = ArrayHelper::merge($body, $notification);
        return $this->send($body);
    }
}
