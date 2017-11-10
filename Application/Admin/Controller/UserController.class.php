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
	//账户状态启用停用
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
	public function update(){
		

		
        $M_mployee = M('mployee');
        $M_department = M('department');
        $M_product = M('product');
		$userid = I('get.userid');
		$where = array(
			'userid'=>$userid
		);
		$info = $M_mployee->where($where)->find();
		if($info['dep_json']){
			$info['dep_json'] = json_decode($info['dep_json'],true);
		}else{
			$info['dep_json'] = '';
		}

		if(IS_AJAX){
//			print_r($_GET);
			$name = I('get.name');
			$value = I('get.value');
			$num = I('get.key');
			
			$w = array(
				'name'=>$name,
				'value'=>$value
			);
			if($name == '请选择产品' || $value == -1){
				$msg['code'] = 3;
			}elseif(is_array($info['dep_json'])){
				if(in_array($w, $info['dep_json'])){
					$msg['code'] = 0;
				}else{		
					unset($info['dep_json'][$num]);
					$info['dep_json'][] = $w;
					$json = json_encode($info['dep_json']);
					if($M_mployee->where($where)->save(array('dep_json' => $json))){
						$msg['code'] = 0;
					}else{
						$msg['code'] = 1;
					}
				}
			}else{
				$json = json_encode(array($w));
				if($M_mployee->where($where)->save(array('dep_json' => $json))){
					$msg['code'] = 0;
				}else{
//					echo $M_mployee->_sql();
					$msg['code'] = 2;
				}	
					
			}
			echo json_encode($msg);die();
		}
		$dep_list = $M_department->select();
        $product_list = $M_product->select();
		
//		print_r($info);
		$this->assign('info',			$info);
		$this->assign('dep_list',		$dep_list);
		$this->assign('product_list',	$product_list);
		
		
		$this->display();
	}
	public function update_dep(){
        $M_mployee = M('mployee');
		
		if(IS_AJAX){
			$dep_now = I('get.dep_now');
			$userid  = I('get.userid');
			
			$w = array(
				'dep_now'=>$dep_now
			);
			$where = array(
				'userid'=>$userid
			);
			if($M_mployee->where($where)->save($w)){
				$msg['code'] = 0;
			}else{
				$msg['code'] = 2;
			}
			
			echo json_encode($msg);die();
		}
	}
	public function remove(){
		$M_mployee = M('mployee');
		
		if(IS_AJAX){
			
			
			$num = I('get.key');
			$userid  = I('get.userid');
			if(!$num){
				$msg['code'] = 3;
			}
			$where = array(
				'userid'=>$userid
			);
			$info = $M_mployee->where($where)->find();
			if($info['dep_json']){
				$info['dep_json'] = json_decode($info['dep_json'],true);
			}else{
				$info['dep_json'] = '';
			}
			unset($info['dep_json'][$num]);

			$json = json_encode($info['dep_json']);
			if($M_mployee->where($where)->save(array('dep_json' => $json))){
				$msg['code'] = 0;
			}else{
				$msg['code'] = 1;
			}
			echo json_encode($msg);die();
		}
	}
}
