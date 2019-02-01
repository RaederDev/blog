<?php

namespace modules;

use Craft;
use craft\events\TemplateEvent;
use craft\web\View;
use yii\base\Event;

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

        Craft::$app->getView()->registerTwigExtension(new H2PushHelper());

        Event::on(View::class, View::EVENT_AFTER_RENDER_PAGE_TEMPLATE, function (TemplateEvent $ev) {
            $assets = [];

            //iterate over assets to build Link substrings
            foreach (H2PushHelper::$assetsToPush as $asset => $config) {
                $type = $config['type'];
                if ($config['crossorigin']) {
                    $assets[] = "<$asset>; rel=preload; as=$type; crossorigin";
                } else {
                    $assets[] = "<$asset>; rel=preload; as=$type";
                }
            }

            if (count($assets) < 1) {
                return;
            }

            //now we add our header
            Craft::$app
                ->getResponse()
                ->getHeaders()
                ->add('Link', implode(',', $assets));
        });

    }
}
