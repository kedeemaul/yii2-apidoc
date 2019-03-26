<?php
namespace yii2docs\apidoc;

use Yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'yii2docs\apidoc\controllers';
    public $debugHost;
    public $moduleName;
    public function init()
    {
    	if (!$this->debugHost) {
    		$this->debugHost = Yii::$app->request->getHostInfo() . Yii::$app->request->getBaseUrl();
    	}
    	if (!$this->moduleName) {
    		$this->moduleName = 'apidoc';
    	}
        parent::init();
    }
}
