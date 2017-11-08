<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	<meta http-equiv="X-UA-Compatible" content="IE=edge">	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0" /><!--判断手机端代码-->	<title>后台管理系统</title>	<meta name="keywords" content="" />	<meta name="description" content="" />	<!--相应式框架css-->	<link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />	<script type="text/javascript" src="/Public/Js/jquery-1.11.1.min.js"></script><script type="text/javascript" src="/Public/Js/jquery-1.9.0.min.js"></script><script type="text/javascript" src="/Public/Js/jquery-3.1.1.min.js"></script>	<script type="text/javascript" src="/Public/Js/MyJs.js"></script></head><body ><div  class="animsition" data-animsition-in="fade-in-left-sm"><!-- ==左侧导航== -->	<div class="left_nav" id="leftH">		<!--线--><div class="bos_inline">&nbsp;</div><!--线结束--><div class="left_nav_head">	<a href="<?php echo U('Index/index');?>"><img src="/Public/Images/sup.png" width="100" height="100"></a>	<h4><?php echo session('auth')['uname'];;?></h4></div><!--线--><div class="bos_inline">&nbsp;</div><!--线结束--><div class="left_nav_other">	<a href="<?php echo U('Login/logout');?>" class="other_left"> Out Admin </a><div>|</div><a href="<?php echo U('/home');?>" class="other_right" target="_blank"> Go Home </a></div><!--线--><div class="bos_inline">&nbsp;</div><!--线结束--><ul class="left_nav_content ">	<li class="<?php echo CONTROLLER_NAME=='Index'?'active':'';?>">		<a href="<?php echo U('Index/index');?>">管理员列表</a>	</li>	<li class="<?php echo CONTROLLER_NAME=='Team'?'active':'';?>">		<a href="<?php echo U('Team/index');?>">部门列表</a>	</li>	<li>		<div>业绩目标设置</div>			<ul>				<li class="<?php echo (CONTROLLER_NAME=='Target'&&ACTION_NAME=='yearTarget')?'active':'';?>">					<a href="<?php echo U('Target/yearTarget');?>">年度总目标</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Target'&&ACTION_NAME=='monthTarget')?'active':'';?>">					<a href="<?php echo U('Target/monthTarget');?>">月份总目标</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Target'&&ACTION_NAME=='teamTarget')?'active':'';?>">					<a href="<?php echo U('Target/teamTarget');?>">团队月目标</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Target'&&ACTION_NAME=='personageTarget')?'active':'';?>">					<a href="<?php echo U('Target/personageTarget');?>">个人月目标</a>				</li>			</ul>	</li>	<li>		<div>业绩目标统计</div>			<ul>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='allStatistical')?'active':'';?>">					<a href="<?php echo U('Statistical/allStatistical');?>">总业绩统计</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='monthStatistical')?'active':'';?>">					<a href="<?php echo U('Statistical/monthStatistical');?>">当月业绩统计</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='quarterYearStatistical')?'active':'';?>">					<a href="<?php echo U('Statistical/quarterYearStatistical');?>">近三月业绩统计</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='thisYearStatistical')?'active':'';?>">					<a href="<?php echo U('Statistical/thisYearStatistical');?>">今年业绩统计</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='threeYearStatistical')?'active':'';?>">					<a href="<?php echo U('Statistical/threeYearStatistical');?>">近三年业绩统计</a>				</li>				<li class="<?php echo (CONTROLLER_NAME=='Statistical'&&ACTION_NAME=='update_team_performance')?'active':'';?>">					<a href="<?php echo U('Statistical/update_team_performance');?>">业绩修改</a>				</li>			</ul>	</li><li>		<div>会员管理</div>			<ul>				<li class="<?php echo (CONTROLLER_NAME=='User'&&ACTION_NAME=='index')?'active':'';?>">					<a href="<?php echo U('User/index');?>">会员列表</a>				</li>			</ul>	</li></ul>	</div>	<!-- ==右侧内容栏== -->	<div class="right_content" id="rightC">			<!--工具栏-->
<div class="C_right_top">
    <div>
        <input type="button"onclick="UpDateMessage()" value="同步部门和人员信息">
        <div>上次同步时间：<?php echo ($Syn['last_time']?$Syn['last_time']:''); ?></div>
        <div>上次同步IP：<?php echo ($Syn['last_ip']?$Syn['last_ip']:''); ?></div>
        <div>上次操作人员：<?php echo ($Syn['username']?$Syn['username']:''); ?></div>
    </div>
</div>




<div>
	<table border="1" bgcolor="#deb887" id="Syn_personage">
        <tr>
            <td>id</td>
            <td>姓名</td>
            <td>手机</td>
            <td>部门</td>
            <td>状态</td>
            <td>操作</td>
        </tr>

        <?php if(is_array($userlist)): foreach($userlist as $key=>$user): ?><tr>

                <td><?php echo ($user["id"]); ?></td>
                <td><?php echo ($user["name"]); ?></td>
                <td><?php echo ($user["mobile"]); ?></td>
                <td><?php echo ($user["dep_name"]); ?></td>
                <td><a href="javascript:void(0);" onclick="save_user(this,<?php echo ($user["userid"]); ?>)" ustatus="<?php echo ($user["status"]); ?>" ><?php echo ($user["status_name"]); ?></a></td>
                <td></td>
                
            </tr><?php endforeach; endif; ?>
       <tr class="content">
                <!--<td colspan="3" bgcolor="#FFFFFF">&nbsp;<?php echo ($page); ?></td>-->
                <td colspan="3" bgcolor="#FFFFFF"><div class="pages">
                        <?php echo ($page); ?>
                </div></td>  
            </tr>
    </table>
    <br/>
    <script type="text/javascript">
    	function save_user(obj,userid){
    		var status = $(obj).attr('ustatus');
    		$.ajax({
    			type:"get",
    			url:"<?php echo U('User/save');?>",
    			async:true,
    			data:"userid="+userid+"&status="+status,
    			dataType:'json',
    			success:function(result){
    				if(result.code == 0){
    					var sta = result.list == 1?'启用':'停用';
    					var stanum = result.list == 1?1:0;
    					
    					$(obj).html(sta);
    					$(obj).attr('ustatus',stanum);
    					
    				}
    			}
    		});
    	}
    </script>
    <style type="text/css">
            	.pages a,.pages span {
				    display:inline-block;
				    padding:2px 5px;
				    margin:0 1px;
				    border:1px solid #f0f0f0;
				    -webkit-border-radius:3px;
				    -moz-border-radius:3px;
				    border-radius:3px;
				}
				.pages a,.pages li {
				    display:inline-block;
				    list-style: none;
				    text-decoration:none; color:#58A0D3;
				}
				.pages a.first,.pages a.prev,.pages a.next,.pages a.end{
				    margin:0;
				}
				.pages a:hover{
				    border-color:#50A8E6;
				}
				.pages span.current{
				    background:#50A8E6;
				    color:#FFF;
				    font-weight:700;
				    border-color:#50A8E6;
				}
            </style>
</div>	</div>	</div><script type="text/javascript">	// 同步部门和员工信息到数据库	function UpDateMessage(){		//传值		var Url     =  "<?php echo U('Index/Synchronization');?>";		$.ajax({			url:Url,  //显示数据的处理页面			data:{}, //页数和查询都要传值			type:"POST",			dataType:"JSON", //这里我们用JSON的数据格式			success: function(data){				//console.log(data);				alert(data.msg);				location.reload(true);			}		});	}	//设置个人目标额	function changeTarget(num){		var userid   = document.getElementById('userid_'+num).value;		var name   = document.getElementById('name_'+num).value;		var target = document.getElementById('target_'+num).value;		//alert(target);		//传值		var Url     =   "<?php echo U('Target/personageAjax');?>";		var item    = {'userid':userid,'name':name,'target':target}		$.ajax({			url:Url,  //显示数据的处理页面			data:item, //页数和查询都要传值			type:"POST",			dataType:"JSON", //这里我们用JSON的数据格式			success: function(data) {				//console.log(data)				alert(data.msg);				location.reload(true);			}		});	}	function all_change(){		//var name_str = document.getElementById("name_str").value		var target_str = document.getElementById("target_str").value		if(target_str == ""){			alert("没有需要设置或改变的金额");			return false;		}		return true;	}	//批量操作个人目标额	function  target_change(num){		var new_userid = "";		var new_name = "";		var new_target = "";		var userid_id = "userid_"+num;		var name_id = "name_"+num;		var target_id = "target_"+num;		var userid_str = document.getElementById('userid_str').value;		var name_str = document.getElementById('name_str').value;		var target_str =document.getElementById('target_str').value;		var userid = document.getElementById(userid_id).value;		var name = document.getElementById(name_id).value;		var target =document.getElementById(target_id).value;		if(name_str==''){			new_userid = userid;			new_name = name;			new_target = target;		}else{			var new_str = split_str(userid_str,name_str,target_str,userid,name,target);			new_userid 	= new_str.userid_str;			new_name 	= new_str.name_str;			new_target	=new_str.target_str;		}		/*alert(new_name);		alert(new_target);*/		document.getElementById('userid_str').value = new_userid;		document.getElementById('name_str').value = new_name;		document.getElementById('target_str').value = new_target;		return;	}	function split_str(userid_str,name_str,target_str,userid,name,target){		var userIds = new Array();		var names = new Array();		var targets = new Array();		userIds	=	userid_str.split(","); //字符分割		names	=	name_str.split(","); //字符分割		targets	=	target_str.split(","); //字符分割		var new_userId_str = '';		var new_name_str = '';		var new_target_str = '';		if(name_str.indexOf(name) == -1){			new_userId_str = userid_str+','+userid;			new_name_str = name_str+','+name;			new_target_str = target_str+','+target;		}else{			new_name_str = name_str;			for(var i= 0 ; i < names.length ; i++){				if(names[i]==name){					userIds[i] = userid;					targets[i] = target;				}			}			new_userId_str = userIds.join(',')			new_target_str = targets.join(',')		}		return {userid_str:new_userId_str,name_str:new_name_str,target_str:new_target_str};	}	//获取产品的销售排序	function changeProducts(type){		var product = document.getElementById('product').value;		var Url     =   "<?php echo U('Statistical/get_product');?>";		var item    = {'product':product,'type':type}		$.ajax({			url:Url,  //显示数据的处理页面			data:item, //页数和查询都要传值			type:"POST",			dataType:"JSON", //这里我们用JSON的数据格式			success: function(data) {				console.log(data)				if(data.code==-1){					alert(data.msg);					location.reload(true);				}else{					var list_personage,Syn_personage,list_department,Syn_department;					list_personage	=new StringBuffer();					list_department	=new StringBuffer();					Syn_personage 	= data.list.personage;					Syn_department = data.list.department;					/*个人产品总业绩*/					$.each((Syn_personage),function(i,result){						list_personage.append("<tr>");						list_personage.append("<td>"+(i+1)+"</td>");						list_personage.append("<td>"+result.name+"</td>");						list_personage.append("<td>"+result.sum+"</td>");						list_personage.append("</tr>");					});					var head_personage="<tr><th colspan='3'>"+type+"个人产品总销售额排名</th></tr><tr><td>排名</td><td>姓名</td><td>总销售额(元)</td></tr>";					/*按部产品总业绩*/					$.each((Syn_department),function(m,item){						list_department.append("<tr>");						list_department.append("<td>"+(m+1)+"</td>");						list_department.append("<td>"+item.dep_name+"</td>");						list_department.append("<td>"+item.sum+"</td>");						list_department.append("</tr>");					});					var head_department="<tr><th colspan='3'>"+type+"部门产品总销售额排名</th></tr><tr><td>排名</td><td>部门名称</td><td>总销售额(元)</td></tr>";					$("#Syn_personage").html(head_personage+list_personage.toString());					$("#Syn_department").html(head_department+list_department.toString());				}			}		});	}	// 高效的字符串拼接函数，替代使用+号的低效率拼接，使用时直接复制即可	function StringBuffer() {		this.__strings__ = new Array();	}	StringBuffer.prototype.append = function (str) {		this.__strings__.push(str);		return this;    //方便链式操作	}	StringBuffer.prototype.toString = function () {		return this.__strings__.join("");	}</script></body></html>