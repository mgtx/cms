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
</div>