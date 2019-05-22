<?php

namespace app\modules\shop;

use app\modules\shop\assets\ProductAssets;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\conduit\commands';
        }
        $this->registerAssets();
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        Bootstrap::setConfig($app);
    }

    private function registerAssets()
    {
        if (!\Yii::$app instanceof \yii\web\Application) {
            return;
        }

        ProductAssets::register(\Yii::$app->view);
    }
}
