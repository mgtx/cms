<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="C_right_top">
    <div>
        <input type="button"onclick="UpDateMessage()" value="同步部门和人员信息">
        <div>上次同步时间：<?php echo ($Syn['last_time']?$Syn['last_time']:''); ?></div>
        <div>上次同步IP：<?php echo ($Syn['last_ip']?$Syn['last_ip']:''); ?></div>
        <div>上次操作人员：<?php echo ($Syn['username']?$Syn['username']:''); ?></div>
    </div>
</div>


<!--展示部分-->
<div class="C_right_content">
    <table>
        <tr>
            <td>员工名称</td>
            <td>月份</td>
            <td>目标额</td>
            <td>操作</td>
        </tr>
        <?php if(is_array($users)): foreach($users as $key=>$team): ?><tr><td><?php echo ($team["dep"]); ?></td></tr>
            <?php if(empty($team[users])){echo '<tr><td>团队还没有成员</td></tr>'; ?>
            <?php }else{ ?>
                <?php if(is_array($team[users])): foreach($team[users] as $key=>$user): ?><tr>
                        <td><?php echo ($user["name"]); ?></td>
                        <td><?php echo ($month); ?></td>
                        <input type="hidden" value="<?php echo ($user["userid"]); ?>" name="userid" id="userid_<?php echo ++$num;?>">
                        <input type="hidden" value="<?php echo ($user["name"]); ?>" name="name" id="name_<?php echo ($num); ?>">
                        <td><input type="text" value="<?php echo ($user["target"]); ?>" name="target" id="target_<?php echo ($num); ?>" onchange="target_change('<?php echo ($num); ?>')"></td>
                        <td><button onclick="changeTarget('<?php echo ($num); ?>')">提交</button></td>
                    </tr><?php endforeach; endif; ?>
            <?php ;} endforeach; endif; ?>
    </table>
    <form action="<?php echo U('Target/personagePost');?>" method="post" name="targetAll" onsubmit = "return all_change()">
        <input type="hidden" name="userids" value="" id="userid_str">
        <input type="hidden" name="names" value="" id="name_str">
        <input type="hidden" name="targets" value="" id="target_str">
        <input type="submit" value="全部提交">
    </form>
</div>

