<?php

namespace app\modules\shop\models;

use Faker\Factory;
use yii\base\Component;
use yii\base\Exception;

class Seeder extends Component
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function init()
    {
        parent::init();
        $this->faker = Factory::create();
    }

    public static function run()
    {
        $model = new static();
        $model->seed();
    }

    /**
     * @throws Exception
     */
    private function seed()
    {
        // @TODO implement seeding
    }
}
