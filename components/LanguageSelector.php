<?php

namespace app\components;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\web\Cookie;

class LanguageSelector extends Component implements BootstrapInterface
{
    const PARAM_LANGUAGE = 'language';
    public $supportedLanguages = ['en', 'hu'];

    public static function allowed()
    {
        return [
            'en' => \Yii::t('app', 'English'),
            'hu' => \Yii::t('app', 'Hungarian'),
        ];
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $this->updateLanguageFromRequest($app);
        $this->setPreferredLanguage($app);
    }

    /**
     * @param $app Application
     */
    private function updateLanguageFromRequest($app)
    {
        $language = $app->request->get(self::PARAM_LANGUAGE);

        if (!empty($language) && in_array($language, $this->supportedLanguages) && $language != $this->getPreferredLanguage($app)) {
            $app->language = $language;

            $languageCookie = new Cookie([
                'name' => self::PARAM_LANGUAGE,
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            $app->response->cookies->add($languageCookie);

            $app->response->refresh();
        }
    }

    /**
     * @param $app Application
     */
    public function setPreferredLanguage($app): void
    {
        $app->language = $this->getPreferredLanguage($app);
    }

    /**
     * @param $app Application
     * @return string|null
     */
    public function getPreferredLanguage($app)
    {
        $preferredLanguage = $app->request->cookies[self::PARAM_LANGUAGE] ?? null;

        if (empty($preferredLanguage)) {
            $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
        }

        return $preferredLanguage;
    }
}