<?php

namespace app\modules\frontend;

use app\modules\frontend\assets\ProductAssets;
use Yii;
use yii\web\User;

class Module extends \yii\base\Module
{
    public $user;

    public function init()
    {
        parent::init();
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\frontend\commands';
        }
        $this->registerAssets();
        $this->setLayout();
        $this->setSessionConfig();
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

        Yii::$app->user->loginUrl = ['/frontend/default/login'];

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
                    $this->user[$param] = Yii::$app->user->$param . '_frontend';
                }
            }

            Yii::$app->set('user', $this->user);
        }
    }

    public function setLayout(): void
    {
        $this->layout = '@app/modules/frontend/views/layouts/main.php';
    }
}
