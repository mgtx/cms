<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

            <td>姓名</td>
            <td>金额(元)</td>
            <td>单位名称</td>
            <td>收款原因</td>
            <td>时间</td>
            <td>业绩所属</td>
        </tr>

        <?php if(is_array($data)): foreach($data as $key=>$personage): ?><tr>

                <td><?php echo ($personage["name"]); ?></td>
                <td><?php echo ($personage["money"]); ?></td>
                <td><?php echo ($personage["units_name"]); ?></td>
                <td><?php echo ($personage["cause"]); ?></td>
                <td><?php echo ($personage["create_time"]); ?></td>


                <td onclick="w(this);" log_id="<?php echo ($personage["id"]); ?>" time="<?php echo ($personage["create_time"]); ?>"><?php echo ($personage["dep_name"]); ?></td>
                
            </tr><?php endforeach; endif; ?>
        <script type="text/javascript">
        	function w(obj){
                $(obj).html("<select  mouseout='r(this);' onchange='newteam(this);' class='newteam' name='newteam'>"+"<?php echo ($dep); ?>"+"</select>");
                $(obj).removeAttr("onclick")
        	}
        	function f(obj){
$(obj).parent().attr("onclick","w(this);")
        		$(obj).parent().html($(obj).find("option:selected").text())
        	}
        	function newteam(obj){
        		var log_id = $(obj).parent().attr('log_id');
        		var newteam = $(obj).find("option:selected").val();
        		var time = $(obj).parent().attr('time');
        		$.ajax({
        			type:"get",
        			url:"<?php echo U('statistical/update_team_performance');?>",
        			async:true,
        			data:'log_id='+log_id+'&newteam='+newteam,
        			dataType:'text',
        			success:function(data){
        				if(data == 0){
        					$(obj).parent().attr("onclick","w(this);")
        					$(obj).parent().html($(obj).find("option:selected").text())
        				}
        			}
        		});
        		
			};
			function r(obj){
        		$(obj).parent().attr("onclick","w(this);")
        		$(obj).parent().html($(obj).find("option:selected").text())
			};
        </script>
		 <tr class="content">
                <!--<td colspan="3" bgcolor="#FFFFFF">&nbsp;<?php echo ($page); ?></td>-->
                <td colspan="3" bgcolor="#FFFFFF"><div class="pages">
                        <?php echo ($page); ?>
                </div></td>  
            </tr>
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
    </table>
    <br/>
</div>