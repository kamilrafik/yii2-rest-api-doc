<?php

namespace nostop8\yii2\rest_api_doc;

use yii\base\BootstrapInterface;
use yii\base\Module as YiiModule;

class Module extends YiiModule implements BootstrapInterface
{
    public $controllerNamespace = 'nostop8\yii2\rest_api_doc\controllers';

    public $showRequestForm = false;

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            $this->id => $this->id . '/default/index',
            $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>' => $this->id . '/<controller>/<action>',
            ], false);
    }
}
