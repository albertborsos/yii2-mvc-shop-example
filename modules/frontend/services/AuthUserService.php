<?php

namespace app\modules\frontend\services;

use app\modules\frontend\domains\user\User;
use app\modules\shop\components\Service;
use yii\authclient\ClientInterface;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class AuthUserService extends Service
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute()
    {
        $attributes = $this->client->getUserAttributes();
        $id = ArrayHelper::getValue($attributes, 'id');

        $user = User::findOne(['google_id' => $id]);

        if (empty($user)) {
            $user = new User([
                'google_id' => $id,
                'name' => ArrayHelper::getValue($attributes, 'name'),
                'picture' => ArrayHelper::getValue($attributes, 'picture'),
            ]);
            $user->save();
        }

        return $this->login($user);
    }

    public function login(User $user)
    {
        /** @var \yii\web\User $userComponent */
        $userComponent = Instance::ensure('user', \yii\web\User::class);
        return $userComponent->login($user, 3600 * 24 * 30);
    }
}