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
    <div >
        <form action="<?php echo U('Target/teamTarget');?>" method="post">

            <label>部门：</label><select name="dep_name" id="deps">
            <option value="0">请选择部门</option>
            <?php if(is_array($deps)): foreach($deps as $key=>$item): ?><option value="<?php echo ($item["dep_name"]); ?>_<?php echo ($item["dep_id"]); ?>" name="dep_name"><?php echo ($item["dep_name"]); ?></option><?php endforeach; endif; ?>
        </select>
            <label>目标额：</label><input type="text" name="target">
            <input type="hidden" name="month" value="<?php echo ($month); ?>">
            <input type="submit" name="submit" value="提交">
        </form>
        <hr/>
        <table>
            <tr>
            <tr><th colspan="3">团队<?php echo ($month); ?>月份目标</th></tr>
            <tr>
                <td>部门编号</td>
                <td>部门名称</td>
                <td>月目标(元)</td>
            </tr>
            <?php if(empty($team_month_target)){echo '<tr><td colspan="3">当月还未设置任何月目标团队</td></tr>';?>
            <?php }else{ ?>
                <?php if(is_array($team_month_target)): foreach($team_month_target as $key=>$team): ?><tr>
                        <td><?php echo ($team["id"]); ?></td>
                        <td><?php echo ($team["dep_name"]); ?></td>
                        <td><?php echo $team['target']?$team['target']:0;?></td>
                    </tr><?php endforeach; endif; ?>
            <?php ;} ?>
        </table>
    </div>
</div>
