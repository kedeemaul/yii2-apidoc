<?php
namespace yii2docs\apidoc\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii2docs\apidoc\models\ActionModel;

class ApiController extends Controller
{
	# 不使用公共模板
	public $layout = false;
	
	public function getRequest()
	{
		return \Yii::$app->getRequest();
	}
	
	public function getResponse()
	{
		return \Yii::$app->getResponse();
	}

	/**
	 * 文档首页
	 */
	public function actionIndex()
	{
		$action = $this->request->get('action');
		$navItems = [];
		$currentAction = null;
		$debugRoute = $debugUrl = '';
		# 获取配置数据
		$configs = Yii::$app->params['apiList'];
		foreach ($configs as $config) {
			$items = [];
			$rf = new \ReflectionClass($config['class']);
			$debugHost = $config['debugHost'];
			# 获取公共方法
			$methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($methods as $method) {
				if (strpos($method->name, 'action') === false || $method->name == 'actions') {
					continue;
				}
				$actionModel = new ActionModel($method);

				if($actionModel->getTitle() == $method->name) {
					continue;
				}
				$active = false;
				if ($action) {
					list($class, $actionName) = explode('::', $action);
					if ($class == $config['class'] && $actionName == $method->name) {
						$currentAction = $actionModel;
						$debugRoute = $actionModel->getRoute();

						$debugUrl = $debugHost . '/' . $debugRoute;
					
						$active = true;
					}
				}
				$items[] = [
					'label' => $actionModel->getTitle(),
					'url' => Url::to(['', 'action' => "{$config['class']}::{$method->name}"]),
					'active' => $active,
				];
			}
			$navItems[] = [
				'label' => $config['label'],
				'url' => '#',
				'items' => $items
			];
		}
		return $this->render('api', [
			'action' => $action, 
			'navItems' => $navItems,
			'model' => $currentAction,
			'debugRoute' => $debugRoute,
			'debugUrl' => $debugUrl,
		]);
	}

	
}