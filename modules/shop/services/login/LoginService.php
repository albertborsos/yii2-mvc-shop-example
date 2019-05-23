<?php

namespace app\modules\shop\services\login;

use app\modules\shop\components\Service;
use app\modules\shop\services\login\forms\LoginForm;
use Yii;
use yii\di\Instance;
use yii\helpers\VarDumper;
use yii\web\User;

/**
 * Class LoginService
 * @package app\modules\shop\services\login
 * @property LoginForm $form
 */
class LoginService extends Service
{
    public function execute()
    {
        return $this->login();
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     * @throws \yii\base\InvalidConfigException
     */
    public function login()
    {
        /** @var User $userComponent */
        $userComponent = Instance::ensure('user', User::class);
        return $userComponent->login($this->form->getAdmin(), $this->form->rememberMe ? 3600 * 24 * 30 : 0);
    }
}
