<?php

namespace app\modules\shop;

use app\modules\frontend\assets\ProductAssets;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\User;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $user;

    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\shop\commands';
        }
        $this->registerAssets();
        $this->setLayout();
        $this->setSessionConfig();
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


    private function setSessionConfig()
    {
        if (!\Yii::$app instanceof \yii\web\Application) {
            return;
        }

        Yii::$app->user->loginUrl = ['/shop/default/login'];

        if ($this->user !== null) {
            if (!isset($this->user['class'])) {
                $this->user['class'] = User::class;
            }

            $params = [
                'idParam',
                'authTimeoutParam',
                'absoluteAuthTimeoutParam',
                'returnUrlParam',
            ];

            foreach ($params as $param) {
                if (!isset($this->user[$param])) {
                    $this->user[$param] = Yii::$app->user->$param . '_admin';
                }
            }

            Yii::$app->set('user', $this->user);
        }
    }

    public function setLayout(): void
    {
        $this->layout = '@app/modules/shop/views/layouts/main.php';
    }
}
