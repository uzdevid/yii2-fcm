<?php

namespace uzdevid\fcm;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\AssetBundle;
use yii\web\View;

class FcmAsset extends AssetBundle {
    public $sourcePath = '@vendor/uzdevid/yii2-fcm/assets';

    public $js = [
        [
            'js/notification.js',
            'type' => 'module'
        ]
    ];

    public function registerAssetFiles($view) {
        if (empty(Yii::$app->params['fcm'])) {
            throw new InvalidConfigException(Yii::t('app', 'Firebase config not found'));
        }

        $script = "const firebaseConfig = " . json_encode(Yii::$app->params['fcm']) . ";";
        $view->registerJs($script, View::POS_HEAD);

        parent::registerAssetFiles($view);
    }
}