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
    <div class=" " >
        <table border="1">
            <tr class="">
                <td>编号</td>
                <td>管理员ID</td>
                <td>创建时间</td>
            </tr>
            <?php if(is_array($admin)): foreach($admin as $key=>$item): ?><tr  class=" ">
                    <td><?php echo ($item["id"]); ?></td>
                    <td><?php echo ($item["username"]); ?></td>
                    <td><?php echo ($item["create_time"]); ?></td>
                </tr><?php endforeach; endif; ?>

        </table>
    </div>
</div>

