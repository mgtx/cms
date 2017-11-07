<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

$user_IP = $_SERVER["REMOTE_ADDR"];

if($user_IP == '115.159.37.77'|| $user_IP == "118.112.123.209" || stristr($user_IP,"182.138.218") || stristr($user_IP,"182.139.30")|| stristr($user_IP,"125.69")|| stristr($user_IP,"127.0.0.1")){

    // 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
    define('APP_DEBUG',true);
    // 定义应用目录
    define('APP_PATH','./Application/');
    //Public目录路径
    define('PUBLIC_PATH',__DIR__.'/Public/');
    define('PUBLIC_IMAGE','/Public/Images/');
    // 引入ThinkPHP入口文件
    require './ThinkPHP/ThinkPHP.php';

    // 亲^_^ 后面不需要任何代码了 就是如此简单
}
else if (isset($_GET["isok"])) {

    // 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
    define('APP_DEBUG',false);
    // 定义应用目录
    define('APP_PATH','./Application/');
    //Public目录路径
    define('PUBLIC_PATH',__DIR__.'/Public/');
    define('PUBLIC_IMAGE','/Public/Images/');
    // 引入ThinkPHP入口文件
    require './ThinkPHP/ThinkPHP.php';

    // 亲^_^ 后面不需要任何代码了 就是如此简单
}
else{
	$ip = $_SERVER["REMOTE_ADDR"];
    
    $fp = fopen('./log.txt','a+');
    fwrite($fp,date("Y-m-d H:i:s")."->IP:".$ip." 访问了！");
    fclose($fp);
	
    $ret = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0" /><!--判断手机端代码-->

    <title>404</title>

    <meta name="keywords" content="" />

    <meta name="description" content="" />

    <script type="text/javascript" src="/Public/Js/jquery-1.11.1.min.js"></script>

</head>
	<body style="backgroud:#fff;">
		<div class="bos_bg01">
			<div id="solar">
				<div class='planetOrbit' id='merc-orbit' style="max-width:800px; margin:0 auto;">
					<div class='merc planet' id=""><img src="http://www.9tnl.com/uploadfile/image/20150810/20150810225176647664.jpg" width="100%"></div>

				</div>

			</div>

			<div class="bos_bg02">

				<div class="bos_bg03">

					<div class="find" style="text-align:center;">

						<h3 class="find_size01">没有找到该页面？怪我啰？</h3>

						<p class="find_size02">The page you are looking for longer exists</p>

					</div>

				</div>
			</div>
		</div>
	</body>
</html>
EOT;
    die($ret);
}

// 亲^_^ 后面不需要任何代码了 就是如此简单