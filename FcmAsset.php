<?php

namespace uzdevid\fcm;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class FcmAsset
 * @package uzdevid\yii2-fcm
 * @category Yii2 Extension
 * @version 1.0.0
 * @author UzDevid - Ibragimov Diyorbek
 * @license MIT
 */
class FcmAsset extends AssetBundle {
    public $sourcePath = '@vendor/uzdevid/yii2-fcm/assets';

    public $js = [
        [
            'js/notification.js',
            'type' => 'module'
        ]
    ];

    public function registerAssetFiles($view) {
        parent::registerAssetFiles($view);

        if (empty(Yii::$app->params['fcm'])) {
            return;
        }

        $script = "const firebaseConfig = " . json_encode(Yii::$app->params['fcm']) . ";";
        $view->registerJs($script, View::POS_HEAD);
    }
}