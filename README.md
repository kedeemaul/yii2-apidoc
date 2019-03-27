# yii2-apidoc
yii2 通过API动作方法的注释，自动生成可阅读可调试的API文档

### 安装  
```php
composer require kedeemaul/yii2-apidoc
```
### 配置  
#### 1、配置到模块数组  
假设我们要放到 `backend` 项目下 
config/main.php的modules数组中加入以下内容
 
```php
    'apidoc' => [
        'class' => 'yii2docs\apidoc\Module',
        # 配置访问接口的host
        'debugHost' => 'http://api.yiidoc.com',
        # 和配置时定义的模块名一致
        'moduleName' => 'apidoc',
    ]
```
<!-- more -->
#### 2、配置需要接口文档的控制器    
config/params.php加入以下内容

```php
return [
	'apiList' => [
		'test' => [
			'label' => '文档测试',
			'class' => 'api\controllers\ApidocController',
		],
		'test2' => [
			'label' => '文档测试2',
			'class' => 'api\controllers\Apidoc2Controller',
		],
	],
];
```



### 生成文档的备注格式   

**@name表示接口名称，不注释则文档不显示该接口**

@uses 表示接口简介/用途等，可空

@method 表示请求方式，不注释默认为get

@author 作者姓名

@create 创建日期

@request 参数传递说明，如“参数名以*号开头表示必填”

@param 表示请求参数，可多个，后面分别跟类型、参数名，备注

@response 返回内容介绍，如“返回JSON结构体，具体键值如下”

@return 表示返回内容，可多个，后面分别跟类型、返回名，备注

```php
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
```
 

### 示例  

可以编辑文档说明和示例  

![apidoc0](https://raw.githubusercontent.com/kedeemaul/githubs/master/apidoc0.jpg) 

接口调试

![apidoc1](https://raw.githubusercontent.com/kedeemaul/githubs/master/apidoc1.jpg)

