<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="C_right_top">
    <div>
        <input type="button"onclick="UpDateMessage()" value="同步部门和人员信息">
        <div>上次同步时间：<?php echo ($Syn['last_time']?$Syn['last_time']:''); ?></div>
        <div>上次同步IP：<?php echo ($Syn['last_ip']?$Syn['last_ip']:''); ?></div>
        <div>上次操作人员：<?php echo ($Syn['username']?$Syn['username']:''); ?></div>
    </div>
</div>


<!--统计展示 start-->
<div style="font-size: 18px;color:#fff3e7;"><?php echo ($title_pre); ?>已通过审批总业绩金额(元)：<?php echo ($_date["sum"]); ?></div>

<!--部门总业绩排名-->
<table border="1" bgcolor="#deb887" >
    <tr><th colspan="3"><?php echo ($title_pre); ?>部门总销售额排名</th></tr>
    <tr>
        <td>排名</td>
        <td>部门名称</td>
        <td>总销售额(元)</td>
    </tr>
    <?php if(empty($_date[team_target])){echo '<tr><td colspan="3">暂无排名</td></tr>'; ?>
    <?php }else{ ?>
    <?php if(is_array($_date[team_target])): foreach($_date[team_target] as $key=>$target): ?><tr >
            <td><?php echo ($key+1); ?></td>
            <td><?php echo ($target["dep_name"]); ?></td>
            <td><?php echo ($target["sum"]); ?></td>
        </tr><?php endforeach; endif; ?>
    <?php ;} ?>
</table>
<br/>
<!--个人总业绩排名-->
<table border="1" bgcolor="#deb887" >
    <tr><th colspan="3"><?php echo ($title_pre); ?>个人总销售额排名</th></tr>
    <tr>
        <td>排名</td>
        <td>姓名</td>
        <td>总销售额(元)</td>
    </tr>
    <?php if(empty($_date[per_target])){echo '<tr><td colspan="3">暂无排名</td></tr>'; ?>
    <?php }else{ ?>
    <?php if(is_array($_date[per_target])): foreach($_date[per_target] as $key=>$target): ?><tr >
            <td><?php echo ($key+1); ?></td>
            <td><?php echo ($target["name"]); ?></td>
            <td><?php echo ($target["sum"]); ?></td>
        </tr><?php endforeach; endif; ?>
    <?php ;} ?>
</table>

<!--统计展示 end-->