<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',      		// 数据库类型
    'DB_HOST'               =>  '192.168.8.94', 		// 服务器地址
    'DB_NAME'               =>  'mgtx_yw',       	// 数据库名
    'DB_USER'               =>  'zkn',       		// 用户名
    'DB_PWD'                =>  'root',             // 密码
    'DB_PORT'               =>  '3306',        		// 端口
    'DB_PREFIX'             =>  'mgtx_',    		// 数据库表前缀
    'DB_PARAMS'          	=>  array(), 			// 数据库连接参数
    'DB_DEBUG'  			=>  TRUE, 				// 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        		// 启用字段缓存
    'DB_CHARSET'            =>  'utf8',     		// 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        =>  0, 					// 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        =>  false,       		// 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         =>  1, 					// 读写分离后 主服务器数量
    'DB_SLAVE_NO'           =>  '', 				// 指定从服务器序号


    //添加公共类库－命名空间
    /*'AUTOLOAD_NAMESPACE' => array(
        'Lib' => APP_PATH . 'Lib',
    ),*/
    // 显示页面Trace信息
    //'SHOW_PAGE_TRACE' =>true,
    'ERROR_PAGE' =>'/Public/Error/404.html',

    /*钉钉相关数配置*/
    'OAPI_HOST'=>'https://oapi.dingtalk.com',
    //绵阳
//    'CorpId'=>'ding560fbf0bffa81a4435c2f4657eb6378f',
//    'CorpSecret'=>'92hMFU5n-NPRTxYIopHKUZwksRrUbQ3MDpP9Xkm0upluNdWd1Jl6C1Ka8T6_xZi2',
    //北京
    'CorpId'=>'ding320c8375d82c35eb',
    'CorpSecret'=>'KUKAi2FoQn3wAh0NX-ujxRFIYnMyjLszUOQtJDTXoJqfj6wsIS4N2NItFhAFx3Cd',

    /*审批接口配置*/
    'ECO_HOST' => "https://eco.taobao.com/router/rest",
    'Method' => "dingtalk.smartwork.bpms.processinstance.list",
    //'ProcessCode'=>"PROC-9X7LTXYU-QN3OOFLNO5WGIIUD9KXO1-SJFSK87J-6",//绵阳审批表达code
    'ProcessCode'=>"PROC-FF6YT8E1N2-ATDO9OAYP6QD53AN9DLC2-3HT0WM7J-6",//北京审批表达code
    'tProcessCode'=>"PROC-0SBKJ8AV-JKPPSWG1NNEFR3W7ZZ5S1-HWV12I9J-F",//北京退款审批表达code
//https://aflow.dingtalk.com/dingtalk/web/query/formDesign?formUuid=FORM-FF6YT8E1N2-WPQPUVOLVH1MHPTKPLGW1-XEPMIJ9J-2&processCode=PROC-0SBKJ8AV-JKPPSWG1NNEFR3W7ZZ5S1-HWV12I9J-F&processStatus=PUBLISHED&dirId=15e8864f50c63f0ec1f0bb74ffa9819a
    

    /*群机器人配置*/
    //'Webhook'=>"https://oapi.dingtalk.com/robot/send?access_token=c40d43417bcdc6cf3d98b1dd2da1f67cceae287b121d6dca40236f75265159cc",//测试群
	'Webhook'=>"https://oapi.dingtalk.com/robot/send?access_token=415614a350192b73d855be18bb22eb8a27adbe02a01f35a9aacafdddc5e57d23",

    //ssl协议本地地址
    'SSL'=>PUBLIC_PATH.'SSL/cacert.pem',


);