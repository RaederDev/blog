<?php

namespace modules;

use Craft;

class Module extends \yii\base\Module
{
    /**
     * Initializes the module.
     */
    public function init()
    {
        // Set a @modules alias pointed to the modules/ directory
        Craft::setAlias('@modules', __DIR__);

        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace = 'modules\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\controllers';
        }

        parent::init();

        if (!Craft::$app->getRequest()->getIsSiteRequest()) {
            return;
        }

        $headers = Craft::$app->getResponse()->getHeaders();
        $headers->add('X-Frame-Options', 'deny');
        $headers->add('Content-Security-Policy', 'script-src \'self\'');
        $headers->add('X-XSS-Protection', '1');
        $headers->add('X-Content-Type-Options', 'nosniff');
        $headers->add('Referrer-Policy', 'same-origin');
        $headers->add('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    }
}
