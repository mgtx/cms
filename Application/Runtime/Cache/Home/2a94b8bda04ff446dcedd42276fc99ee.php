<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"><!--定义宽度，缩放比例-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="renderer" content="webkit"><!--默认用极速核-->
    <!--meta http-equiv="Cache-Control" content="no-siteapp"--><!--不让页面缓存，每次访问必须到服务器读取-->
    <meta name="keywords" content="关键字">
    <meta name="description" content="主要内容">
    <meta name="robots" content="all">
    <!--<meta http-equiv="refresh" content="60">-->
    <!--设定为all：文件将被检索，且页面上的链接可以被查询；
    设定为none：文件将不被检索，且页面上的链接不可以被查询；
    设定为index：文件将被检索；
    设定为follow：页面上的链接可以被查询；
    设定为noindex：文件将不被检索，但页面上的链接可以被查询；
    设定为nofollow：文件可以被检索，但是页面上的链接不可以被查询。-->
    <title>业务展示首页</title>
    <meta name="author" content="作者">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" /><link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.min.css" /><link rel="stylesheet" type="text/css" href="/Public/Css/index.css" />
    <!-- 引入 jQuery -->
    <script type="text/javascript" src="/Public/Js/jquery-1.11.1.min.js"></script><script type="text/javascript" src="/Public/Js/jquery-1.9.0.min.js"></script><script type="text/javascript" src="/Public/Js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/Public/Js/MyJs.js"></script><script type="text/javascript" src="/Public/Js/bootstrap.min.js"></script><script type="text/javascript" src="/Public/Js/index.js"></script>
    
</head>
<body>
<!--<div><a href="<?php echo U('/Admin');?>" target="_Blank">进入后台</a></div>-->
<div class="box" id="boxpc">
	<div class="star pull-left">
		<div id='stars'></div>
	    <div id='stars2'></div>
	    <div id='stars3'></div>
	</div>
    <div class="box1">
    	<div class="container">
    		<div class="row row1">
    			<div class="carousel_header">
		    		<marquee>
			       	<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><span><strong>恭喜：</strong><strong><?php echo ($item["dep_name"]); ?></strong>--<strong><?php echo ($item["name"]); ?></strong>成交<strong><?php echo ($item["cause"]); ?></strong>&nbsp;,&nbsp;年限为：<strong><?php echo ($item["age_limit"]); ?></strong>，金额为：<strong>&yen;<?php echo ($item["money"]); ?></strong>元.</span><?php endforeach; endif; ?>
			       </marquee>
		    	</div>
		    	<div class="carousel_nav text-center">
		    		<ul>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left"><?php echo ($index_date["year_target"]["year"]); ?>年度目标</li>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left">&yen;：<?php echo ($index_date["year_target"]["target"]); ?></li>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left">已完成</li>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left">&yen;：<?php echo ($index_date["year_target"]["complete"]); ?></li>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left">剩余</li>
		    			<li class="col-lg-2 col-md-2 col-sm-2 pull-left">&yen;：<?php echo ($index_date["year_target"]["surplus"]); ?></li>
		    		</ul>
		    	</div>
		    	<div class="carousel_content">
		    		<div class="carousel_content_left text-center col-lg-3 col-md-3 col-sm-3">
		    			<ul>
		    				<li><strong><?php echo substr($index_date[month_target][month],-2); ?>月份集体目标</strong></li>
		    				<li>目标(&yen;):<?php echo ($index_date["month_target"]["target"]); ?></li>
		    				<li>已完成(&yen;):<?php echo ($index_date["month_target"]["complete"]); ?></li>
		    				<li>剩余(&yen;):<?php echo ($index_date["month_target"]["surplus"]); ?></li>
		    				<li>剩余天数:<?php echo ($index_date["surplus_day"]); ?></li>
		    			</ul>
		    			<div class="content_left_nav">
		    				<p>名冠天下业绩栏</p>

<a href="<?php echo U('index/index',array('month'=>1));?>">当月</a>
		    					<a href="<?php echo U('index/index',array('month'=>2));?>">近两月</a>
		    				<script type="text/javascript">
		    					$("#dang").click(function(){
		    						$("#one").css("display",'block');
		    						$("#twe").css("display",'none');
		    					})
		    					$("#new").click(function(){
		    						$("#one").css("display",'none');
		    						$("#twe").css("display",'block');
		    					})
		    				</script>
		    			</div>
		    		</div>
		    		<div class="carousel_content_right col-lg-9 col-md-9 col-sm-9">
		    			<div class="content_right_l col-lg-4 col-md-4 col-sm-4">
	    				<?php if(empty($dep_date)){echo '
				                <div class="carousel_middle_right_content">
				            <div>暂无数据</div>
				        </div>
				        <?php ';}else{ ?>
		    				<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><ul class="content_right_l_ul">
			    					<li class="gongxi text-center"><strong>恭喜!!!</strong></li>
			    					<li class="text-center l_ul_img"><img src="<?php echo ($item["avatar"]); ?>" alt="" width="200" class="img-responsive"></li>
			    					<li class="left_ul_li1"><p>组员:<strong class="name"><?php echo ($item["name"]); ?></strong></p></li>
			    					<li class="left_ul_li1"><p>成交额:<strong><span class="money"><?php echo ($item["money"]); ?></span></strong>元</p></li>
			    					<li class="left_ul_li1"><p>所属小组:<strong><?php echo ($item["dep_name"]); ?></strong></p></li>
			    					<li class="left_ul_li1"><p>组长:<strong><?php echo ($item["leader"]); ?></strong></p></li>
			    					<li class="left_ul_li1"><p>产品类型:<strong><?php echo ($item["cause"]); ?></strong></p></li>
			    					<li class="left_ul_li1"><p>用户数:<strong><?php echo ($item["user_num"]); ?></strong></p></li>
			    					<li class="left_ul_li1"><p>产品年限:<strong><?php echo ($item["age_limit"]); ?></strong></p></li>
			    				</ul><?php endforeach; endif; ?>
		    			<?php ;} ?>	
		    			</div>
		    			<?php if($getmonth == 1){ ?>
					        
		    			<div id="one" class="content_right_r col-lg-8 col-md-8 col-sm-8" >
		    				<div class="table_header text-center">
		    					<p>本月<strong>个人</strong>业绩完成情况(按业绩排名)</p>
		    				</div>
		    				<div class="t_d">
			    				<div class="table_div">
								<div class="table2 table-responsive table_height">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
										    	<tr class="t1_tr1">
											        <th>排名</th>
											        <th>姓名</th>
											        <th>业绩目标</th>
											        <th>已完成</th>
											        <th>剩余</th>
											        <th>是否完成</th>
											    </tr>
										    </thead>
										    <?php if(empty($dep_per)){echo '
										        <tr><td colspan="6">本月未设置任何个人目标</td></tr>
										    <?php ';}else{ ?>
										    <?php if(is_array($dep_per)): foreach($dep_per as $k=>$per): ?><tr class="t1_tr2">
										            <td><?php echo ($k+1); ?></td>
										            <td><?php echo ($per["name"]); ?></td>
										            <td><?php echo ($per["target"]); ?></td>
										            <td><?php echo ($per["complete"]); ?></td>
										            <td><?php echo ($per["surplus"]); ?></td>
										            <td style="color:<?php echo ($per['flg']=='已完成')?'green':'red';?>"  ><?php echo ($per["flg"]); ?></td>
										        </tr><?php endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</div>
				    				<div class="table1 table-responsive table_height">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
											    <tr class="t1_tr1">
											        <th>排名</th>
											        <th>团队名称</th>
											        <th>组长</th>
											        <th>业绩目标</th>
											        <th>已完成</th>
											        <th>剩余</th>
											        <th>是否完成</th>
											    </tr>
										    </thead>
										    <?php if(empty($dep_team)){echo '
										        <tr><td colspan="7">本月未设置任何团队目标</td></tr>
										    <?php ';}else{ ?>
										        <?php if(is_array($dep_team)): foreach($dep_team as $key=>$team): ?><tr class="t1_tr2">
										                <td><?php echo ($key+1); ?></td>
										                <td><?php echo ($team["dep_name"]); ?></td>
										                <td><?php echo ($team["leader"]); ?></td>
										                <td><?php echo ($team["target"]); ?></td>
										                <td><?php echo ($team["complete"]); ?></td>
										                <td><?php echo ($team["surplus"]); ?></td>
										                <td style="color:<?php echo ($team['flg']=='已完成')?'green':'red';?>" ><?php echo ($team["flg"]); ?></td>
										            </tr><?php endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</div>
			    				</div>
			    			</div>
		    			</div>
		    			
		    			<?php }else{ ?>
		    			
		    			
		    			
		    			<div id="twe" class="content_right_r col-lg-8 col-md-8 col-sm-8">
		    				<div class="table_header text-center">
		    					<p>近两月<strong>个人</strong>业绩排名</p>
		    				</div>
		    				<div class="t_d">
			    				<div class="table_div">
								<div class="table2 table-responsive table_height">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
										    	<tr class="t1_tr1">
											        <th>排名</th>
											        <th>姓名</th>

											        <th>已完成</th>


											    </tr>
										    </thead>
										    <?php if(empty($dep_per_2['obj'])){echo '
										        <tr><td colspan="6">本月未设置任何个人目标</td></tr>
										    <?php ';}else{ $i = 1;?>
										    <?php if(is_array($dep_per_2["obj"])): foreach($dep_per_2["obj"] as $k=>$per): ?><tr class="t1_tr2">
										            <td><?php echo ($i); ?></td>
										            <td><?php echo ($per["name"]); ?></td>

										            <td><?php echo ($per["complete"]); ?></td>


										        </tr>
										           <?php $i++; endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</div>
				    				<div class="table1 table-responsive table_height">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
											    <tr class="t1_tr1">
											        <th>排名</th>
											        <th>团队名称</th>
											        <th>组长</th>

											        <th>已完成</th>


											    </tr>
										    </thead>
										    <?php if(empty($dep_team_2['obj'])){echo '
										        <tr><td colspan="7">本月未设置任何团队目标</td></tr>
										    <?php ';}else{ $i = 1;?>
										        <?php if(is_array($dep_team_2["obj"])): foreach($dep_team_2["obj"] as $key=>$team): ?><tr class="t1_tr2">
										                <td><?php echo ($i); ?></td>
										                <td><?php echo ($team["dep_name"]); ?></td>
										                <td><?php echo ($team["leader"]); ?></td>

										                <td><?php echo ($team["complete"]); ?></td>


										            </tr>
														<?php $i++; endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</div>
			    				</div>
			    			</div>
		    			</div>
		    			
		    			<?php ;} ?>
		    			
		    			
		    		</div>
		    		<div class="clearfix"></div>
		    		
		    	</div>
		    	<div class="content_bottom text-center">
			    	<ul>
				       	<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><li class="show"><strong>恭喜：</strong><strong><?php echo ($item["dep_name"]); ?></strong>--<strong><?php echo ($item["name"]); ?></strong>成交<strong><?php echo ($item["cause"]); ?></strong>&nbsp;,&nbsp;年限为：<strong><?php echo ($item["age_limit"]); ?></strong>，金额为：<strong>&yen;<?php echo ($item["money"]); ?></strong>元.</li><?php endforeach; endif; ?>
				    </ul>
	    	    </div>
    		</div>
    	</div>
    </div>
</div>
<div class="box_m" id="boxMobile">
	<div class="container-fluid">
		<div class="star pull-left">
		<div id='stars'></div>
	    <div id='stars2'></div>
	    <div id='stars3'></div>
	</div>
    <div class="box1_m">
    		<div class="row text-center">
    			<div class="title_m">
    				<p>名冠天下业绩栏</p>
    			</div>
    		</div>
    		<div class="row row1_m">
    			<div class="carousel_header_m">
		    		<marquee>
			       	<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><span><strong>恭喜：</strong><strong><?php echo ($item["dep_name"]); ?></strong>--<strong><?php echo ($item["name"]); ?></strong>成交<strong><?php echo ($item["cause"]); ?></strong>&nbsp;,&nbsp;年限为：<strong><?php echo ($item["age_limit"]); ?></strong>，金额为：<strong>&yen;<?php echo ($item["money"]); ?></strong>元.</span><?php endforeach; endif; ?>
			       </marquee>
		    	</div>
		    	<div class="carousel_nav_m text-center">
		    		<ul>
		    			<li class="col-xs-4 pull-left"><?php echo ($index_date["year_target"]["year"]); ?>年度目标</li>
		    			<li class="col-xs-4 pull-left">剩余</li>
		    			<li class="col-xs-4 pull-left">已完成</li>
		    			<li class="col-xs-4 pull-left">&yen;：<?php echo ($index_date["year_target"]["target"]); ?></li>
		    			<li class="col-xs-4 pull-left">&yen;：<?php echo ($index_date["year_target"]["surplus"]); ?></li>
		    			<li class="col-xs-4 pull-left">&yen;：<?php echo ($index_date["year_target"]["complete"]); ?></li>
		    		</ul>
		    	</div>
		    	<div class="clearfix"></div>
		    	<div class="carousel_content_left_m text-center">
	    			<ul>
	    				<li class="col-xs-12 pull-left"><strong><?php echo substr($index_date[month_target][month],-2); ?>月份集体目标</strong></li>
	    				<li class="col-xs-3 pull-left left_a_m">目标</li>
	    				<li class="col-xs-3 pull-left left_a_m">已完成</li>
	    				<li class="col-xs-3 pull-left left_a_m">剩余</li>
	    				<li class="col-xs-3 pull-left left_a_m">剩余天数</li>
	    				<li class="col-xs-3 pull-left left_b_m"><?php echo ($index_date["month_target"]["target"]); ?></li>
	    				<li class="col-xs-3 pull-left left_b_m"><?php echo ($index_date["month_target"]["complete"]); ?></li>
	    				<li class="col-xs-3 pull-left left_b_m"><?php echo ($index_date["month_target"]["surplus"]); ?></li>
	    				<li class="col-xs-3 pull-left left_b_m"><?php echo ($index_date["surplus_day"]); ?></li>
	    			</ul>
	    		</div>
	    		<div class="clearfix line_m"></div>
		    	<div class="carousel_content1_m">
		    		<div class="content_right_l_m">
	    				<?php if(empty($dep_date)){echo '
				                <div class="carousel_middle_right_content">
				            <div>暂无数据</div>
				        </div>
				        <?php ';}else{ ?>
		    				<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><ul class="content_right_l_ul_m">
			    					<li class="gongxi_m text-center"><strong>恭喜!!!</strong></li>
			    					<li class="text-center l_ul_img_m"><img src="<?php echo ($item["avatar"]); ?>" alt="" width="300" class="img-responsive"></li>
			    					<li class="left_ul_li1_m"><p>组员:<strong class="name_m"><?php echo ($item["name"]); ?></strong></p></li>
			    					<li class="left_ul_li1_m"><p>成交额:<strong><span class="money_m"><?php echo ($item["money"]); ?></span></strong>元</p></li>
			    					<li class="left_ul_li1_m"><p>所属小组:<strong><?php echo ($item["dep_name"]); ?></strong></p></li>
			    					<li class="left_ul_li1_m"><p>组长:<strong><?php echo ($item["leader"]); ?></strong></p></li>
			    					<li class="left_ul_li1_m"><p>产品类型:<strong><?php echo ($item["cause"]); ?></strong></p></li>
			    					<li class="left_ul_li1_m"><p>用户数:<strong><?php echo ($item["user_num"]); ?></strong></p></li>
			    					<li class="left_ul_li1_m"><p>产品年限:<strong><?php echo ($item["age_limit"]); ?></strong></p></li>
			    				</ul><?php endforeach; endif; ?>
		    			<?php ;} ?>	
		    		</div>
		    	</div>
		    	<div class="clearfix"></div>
		    		<div class="carousel_content2_m">
		    			<div class="content_right_r_m ">
		    				<div class="table_header_m text-center">
		    					<p>本月<strong>个人</strong>业绩完成情况(按业绩排名)</p>
		    				</div>
		    				<div class="t_d_m">
			    				<ul class="table_div_m">
								    <li class="table2 table-responsive table_height_m show">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
										    	<tr class="t1_tr1_m">
											        <th>排名</th>
											        <th>姓名</th>
											        <th>业绩目标</th>
											        <th>已完成</th>
											        <th>剩余</th>
											        <th>是否完成</th>
											    </tr>
										    </thead>
										    <?php if(empty($dep_per)){echo '
										        <tr><td colspan="6">本月未设置任何个人目标</td></tr>
										    <?php ';}else{ ?>
										    <?php if(is_array($dep_per)): foreach($dep_per as $k=>$per): ?><tr class="t1_tr2_m">
										            <td><?php echo ($k+1); ?></td>
										            <td><?php echo ($per["name"]); ?></td>
										            <td><?php echo ($per["target"]); ?></td>
										            <td><?php echo ($per["complete"]); ?></td>
										            <td><?php echo ($per["surplus"]); ?></td>
										            <td style="color:<?php echo ($per['flg']=='已完成')?'green':'red';?>"  ><?php echo ($per["flg"]); ?></td>
										        </tr><?php endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</li>
				    				<li class="table1_m table-responsive table_height_m">
				    					<table class="table table-bordered" border="1" bordercolor="#999999">
										    <thead>
											    <tr class="t1_tr1">
											        <th>排名</th>
											        <th>团队名称</th>
											        <th>组长</th>
											        <th>业绩目标</th>
											        <th>已完成</th>
											        <th>剩余</th>
											        <th>是否完成</th>
											    </tr>
										    </thead>
										    <?php if(empty($dep_team)){echo '
										        <tr><td colspan="7">本月未设置任何团队目标</td></tr>
										    <?php ';}else{ ?>
										        <?php if(is_array($dep_team)): foreach($dep_team as $key=>$team): ?><tr class="t1_tr2_m">
										                <td><?php echo ($key+1); ?></td>
										                <td><?php echo ($team["dep_name"]); ?></td>
										                <td><?php echo ($team["leader"]); ?></td>
										                <td><?php echo ($team["target"]); ?></td>
										                <td><?php echo ($team["complete"]); ?></td>
										                <td><?php echo ($team["surplus"]); ?></td>
										                <td style="color:<?php echo ($team['flg']=='已完成')?'green':'red';?>" ><?php echo ($team["flg"]); ?></td>
										            </tr><?php endforeach; endif; ?>
										    <?php ;} ?>
										</table>
				    				</li>
			    				</ul>
			    			</div>
		    			</div>
		    		</div>
		    	<div class="clearfix"></div>
	    		<div class="content_bottom_m text-center">
			    	<ul>
				       	<?php if(is_array($dep_date)): foreach($dep_date as $key=>$item): ?><li><strong>恭喜：</strong><strong><?php echo ($item["dep_name"]); ?></strong>--<strong><?php echo ($item["name"]); ?></strong>成交<strong><?php echo ($item["cause"]); ?></strong>&nbsp;,&nbsp;年限为：<strong><?php echo ($item["age_limit"]); ?></strong>，金额为：<strong>&yen;<?php echo ($item["money"]); ?></strong>元.</li><?php endforeach; endif; ?>
				    </ul>
	    	    </div>
    	</div>
    </div>
	</div>
</div>
<script>
	$(function(){
		var oHeight = $(window).width();
		var nub1 = $('link').length;
		var nub2 = $('script').length;
		if(oHeight<768){
			for(var i=0;i<nub1;i++){
				if($('link').eq(i).attr('href') == '/Public/Css/index.css'){
					$('link').eq(i).attr('href','/Public/Css/indexMobile.css');
				}
			}
			for(var i=0;i<nub2;i++){
				if($('script').eq(i).attr('src') == '/Public/Js/index.js'){
					$('script').eq(i).attr('src','');  //   /Public/Js/indexMobile.js
					var head= document.getElementsByTagName('head')[0];  //动态加载
					var script= document.createElement('script');
					script.type= 'text/javascript';
					script.onload = script.onreadystatechange = function() {
					if (!this.readyState || this.readyState === "loaded" || this.readyState === "complete" ) {
					// Handle memory leak in IE  兼容ie
					script.onload = script.onreadystatechange = null;
					} };
					script.src= '/Public/Js/indexMobile.js';
					head.appendChild(script);
				}
			}
			$('#boxpc').css({'display':'none'});
			$('#boxMobile').css({'display':'block'});
		}else{
			for(var i=0;i<nub1;i++){
				if($('link').eq(i).attr('href') == '/Public/Css/indexMobile.css'){
					$('link').eq(i).attr('href','/Public/Css/index.css');
				}
			}
			for(var i=0;i<nub2;i++){
				if($('script').eq(i).attr('src') == '/Public/Js/indexMobile.js'){
					$('script').eq(i).attr('src','/Public/Js/index.js');
				}
			}
			$('#boxMobile').css({'display':'none'});
			$('#boxpc').css({'display':'block'});
		}
	})
</script>

</body>
</html>