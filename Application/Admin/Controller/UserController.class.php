<?php

/**

 * Created by PhpStorm.

 * User: milo

 * Date: 15/3/23

 * Time: 14:05

 */

namespace Admin\Controller;

use Think\Controller;


class UserController extends AuthController{
	public function index(){
        $M_mployee = M('mployee');
        $M_department = M('department');

		$userCount = $M_mployee->field('id,userid,name,avatar,mobile,dep_now,status')->count();
		$p = getpage($userCount,20);
		
		$userTemp = $M_mployee->field('id,userid,name,avatar,mobile,dep_now,status')->order('id desc')->limit($p->firstRow, $p->listRows)->select();

		$depTemp  = $M_department->select();


		foreach ($depTemp as $key => $value) {
			$depList[$value['dep_id']]=$value;
		}
		$userList = array();
		foreach ($userTemp as $key => $value) {
			$userList[$key] = $value;
			$userList[$key]['dep_name'] = $depList[$value['dep_now']]['dep_name'];
			$userList[$key]['status_name'] = $value['status'] == 1?'启用':'停用';
			
		}
		$this->assign('page', $p->show());
        $this->assign('userlist',$userList);
        $this->display();
	}
	public function save(){
		if(IS_AJAX){
        	$M_mployee = M('mployee');
			$userid = I('get.userid');
			$status = I('get.status');
			$save   = $status==1?0:1;
			if($M_mployee->where("userid = $userid")->save(array('status'=>$save))){
				$msg['code'] = 0;
				$msg['msg']  = '修改成功';
				$msg['list']  = $save;
			}else{
				$msg['code'] = 1;
				$msg['msg']  = '修改是吧';
				$msg['list']  = $save;
			}
			echo json_encode($msg);die();
		}
		
	}
}
