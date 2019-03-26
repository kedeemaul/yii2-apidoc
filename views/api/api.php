<?php
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use ibunao\apidoc\widgets\SideNavWidget;

// use frontend\assets\AppAsset;
// AppAsset::register($this);
?>

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="x-ua-compatible" content="ie=7" />
	<?php $this->head() ?>
	<link href="/css/document.css?v7" rel="stylesheet" type="text/css" />
	<script src="/js/common/jquery.min.js" type="text/javascript"></script>
	<title>API接口文档</title>
</head>
<body>
<div id="cpcontainer" style="margin: 50px 20px 0px 0px;">
	<?php $this->beginBody(); ?>
	<nav role="navigation" class="navbar-inverse navbar-fixed-top navbar" id="w13767">
		<div class="navbar-header">
			<a href="<?php echo Url::to(['/'.$this->context->module->moduleName.'/api']); ?>" class="navbar-brand">API接口文档</a>
		</div>
	</nav>
	<div class="row">
	    <div class="col-md-2">
	        <?php echo SideNavWidget::widget([
	            'id' => 'navigation',
	            'items' => $navItems,
	            'view' => $this,
	        ]); ?>
	    </div>
	    <div class="col-md-10 api-content" role="main">
	    <!-- 如果是点击左侧列表请求的  -->
	    	<?php if ($model): ?>
	    	<h3>
	    		<?php echo $model->title; ?>
	    		<?php if ($model->author): ?><span style="font-size:14px;margin-left:20px;color:#999;">— <?php echo $model->author; ?></span><?php endif; ?>
                <?php if ($model->create): ?><span style="font-size:14px;margin-left:0px;color:#999;">于 <?php echo $model->create; ?></span><?php endif; ?>
	    	</h3>
	    	<pre> URL地址：<?php echo $debugUrl; ?><br/> 请求方式：<?php echo $model->method; ?><?php echo $model->uses ? "<br/> <b>用途：{$model->uses}</b>" : ''; ?></pre>
	    	<?php
echo Tabs::widget([
    'items' => [
        [
            'label' => '请求和返回',
            'content' => $this->render('_request', ['caption' => "请求参数",'name' => $model->requesttips, 'values' => $model->params])
                        . $this->render('_response', ['caption' => '返回内容 ','name' => $model->backtips, 'values' => $model->returns]),
            'active' => true,
        ],
        [
            'label' => '在线调试',
            'content' => $this->render('_debug', ['route' => $debugRoute, 'debugUrl' => $debugUrl, 'model' => $model]),
        ]
    ],
]);
	    	?>
	    	<?php else: ?>
	    	<h3>接口注释规范</h3>
	    	<p>@name 表示接口名称，不注释则文档不显示该接口</p>
	    	<p>@uses 表示接口简介/用途等，可空</p>
	    	<p>@method 表示请求方式，不注释默认为get</p>
            <p>@author 作者姓名</p>
            <p>@create 创建日期</p>
            <p>@request 参数传递说明，如“参数名以*号开头表示必填”</p>
	    	<p>@param 表示请求参数，可多个，后面分别跟类型、参数名，备注</p>
            <p>@response 返回内容介绍，如“返回JSON结构体，具体键值如下”</p>
            <p>@return 表示返回内容，可多个，后面分别跟类型、返回名，备注</p>
	    	<pre>
/**
* @name 获取注册验证码
* @uses 用户注册是拉取验证码
* @method get
* @author kedee
* @create 创建日期
* @request 参数传递说明，如“参数名以*号开头表示必填”
* @param string *phone 手机号
* @response 返回JSON结构体，具体键值如下
* @return int status 状态码：1正常，0错误
* @return string msg 提示消息内容
* @return array data 返回消息体数组
*/
public function actionRegGetCode($phone)
{
}
            </pre>

                <p>phpstorm自定义注释模版</p>
            <pre>
/**
* @name 动作方法名称
* @uses 方法用途说明
* @method get
* @author ${DEVUSER}
* @create ${DATE} ${TIME}
* @request 参数名以*号开头表示必填
 ${PARAM_DOC}
* @param 类型 参数名 参数说明
 #if (${TYPE_HINT} != "void")
* @response ${TYPE_HINT} 返回JSON结构体，具体键值如下
* @return int status 状态码：1正常，0错误
* @return string msg 提示消息内容
* @return array data 返回消息体数组
#end
${THROWS_DOC}
 */
            </pre>
	    	<?php endif; ?>
	    </div>
	</div>
	<?php $this->endBody(); ?>
</div>
<script type="text/javascript">
$(function(){
	$('.caption').mouseover(function(){
		$('a', this).show();
	}).mouseout(function(){
		$('a', this).hide();
	});

	$('#go-debug').click(function(){
		var route = $('#debug-route').val();
		if (!route) {
			alert('路由不能为空');
		} else {
			window.open("<?php echo Url::to('/'.$this->context->module->moduleName.'/api/debug'); ?>?route=" + route);
		}
	});
});
</script>
<script src="/js/common/bootstrap.min.js"></script>
</body>
</html>
<?php $this->endPage(); ?>