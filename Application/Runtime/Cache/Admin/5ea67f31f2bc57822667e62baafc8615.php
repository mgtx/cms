<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--工具栏-->
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
    <div>更新设置<?php echo ($yearsDate['year']); ?>年的总目标：
        <form action="<?php echo U('Target/yearTarget');?>" method="post">
            <input type="text" name="target" value="<?php echo ($yearsDate['target']); ?>" >元
            <input type="submit" name="submit">
        </form>
    </div>
    <div><?php echo ($yearsDate['year']); ?>年</div>
    <div>年度总目标：<?php echo ($yearsDate['target']); ?>元</div>
</div>

