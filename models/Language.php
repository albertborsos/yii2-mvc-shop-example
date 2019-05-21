<?php

namespace app\models;

class Language
{
    public static function allowed()
    {
        return [
            'en' => \Yii::t('app', 'English'),
            'hu' => \Yii::t('app', 'Hungarian'),
        ];
    }
}
