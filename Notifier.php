<?php

namespace uzdevid\fcm;

use Exception;
use Yii;
use yii\base\Component;
use yii\web\BadRequestHttpException;

/**
 * Class Notifier
 * @package uzdevid\yii2-fcm
 * @category Yii2 Extension
 * @version 1.0.0
 * @author UzDevid - Ibragimov Diyorbek
 * @license MIT
 */

class Notifier extends Component {
    private string|null $_serverKey = null;

    public function getServerKey(): string|null {
        return $this->_serverKey;
    }

    public function setServerKey(string $serverKey): void {
        $this->_serverKey = $serverKey;
    }

    /**
     * @throws Exception
     */
    public function notify($to, $data, $params = []) {
        $fields = array_merge([
            'to' => $to,
            'notification' => $data,
        ], $params);

        $headers = [
            'Authorization: key=' . $this->_serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result === false) {
            throw new Exception(Yii::t('app', 'Curl error: {error}', ['error' => curl_error($ch)]));
        }

        if (empty($result)) {
            throw new BadRequestHttpException(Yii::t('app', 'Empty response from FCM server'));
        }

        if (!$result['success']) {
            throw new BadRequestHttpException(Yii::t('app', 'FCM server error: {error}', ['error' => json_encode($result, JSON_UNESCAPED_UNICODE)]));
        }

        return $result;
    }
}