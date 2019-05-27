<?php

namespace app\modules\shop\commands;

use app\modules\shop\models\Seeder;
use yii\console\Controller;

class SeederController extends Controller
{
    public function actionIndex()
    {
        return Seeder::run();
    }
}
