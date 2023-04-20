<?php

namespace uzdevid\fcm;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class NotificationAsset extends AssetBundle {
    public $sourcePath = '@vendor/uzdevid/yii2-fcm/assets';

    public $css = [];

    public $js = [
        [
            'js/notification.js',
            'type' => 'module'
        ]
    ];

    public $depends = [];

    public function registerAssetFiles($view) {
        $script = "const firebaseConfig = " . json_encode(Yii::$app->params['fcm']) . ";";
        $view->registerJs($script, View::POS_HEAD);

        parent::registerAssetFiles($view);
    }
}