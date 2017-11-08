<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AuthController {
    public function index(){

        $M_admin = M('admin');

        if($_SESSION['Syn']){
            $Syn = $_SESSION['Syn'];
        }else{

            $M_Syn_log = M('syn_log');
            $Syn = $M_Syn_log->find();
            session('Syn',$Syn);
        }


        $admin = $M_admin->field('id,username,create_time')->select();


        $this->assign('Syn',$Syn);
        $this->assign('admin',$admin);
        $this->display();
    }

    // 同步部门和员工信息到数据库
    public function Synchronization(){
        if(IS_AJAX){

        	
            $Token = get_token();

            //部门同步
            $this->syn_department($Token);

            //员工信息同步
            $this->syn_users($Token);
            //  记录
            $last_date = array(
                'username'=>$_SESSION['auth']['uname'],
                'last_ip'=>$_SERVER['SERVER_ADDR'],
                'last_time'=>date('Y-m-d H:i:s')
            );

            $M_Syn_log = M('syn_log');
            $Log = $M_Syn_log->find();
            if(empty($Log)){
                $M_Syn_log->add($last_date);
            }else{
                $M_Syn_log->where($Log)->save($last_date);
            }

            session('Syn',$last_date);

            $data['code'] = 1;
            $data['msg'] = '数据跟新完成~';
            $this->ajaxReturn($data);

        }
    }

    //同步部门信息
    function syn_department($Token){
        $departmentList = $this->get_department_list($Token);
        $M_Department = M('department');
        $depIds =  $M_Department->field('dep_id')->select();
        if(empty($depIds)){
            $M_Department->addAll($departmentList);
        }else{
            $DepId = array_column($depIds, 'dep_id');
            $update = $departmentList;
            foreach($update as $key=>$item){
                if(in_array($item['dep_id'],$DepId)){
                    unset($update[$key]);
                }
            }
            if(!empty($update)){//添加
                foreach($update as $v){
                    $M_Department->add($v);
                }
            }
            //跟新
            foreach($update as $item){
                $M_Department->where(array('dep_id'=>$item['dep_id']))->save($item);
            }
        }
    }

    //部门列表
    function get_department_list($Token){
        //获取全部授权部门ID
        $Url_Scopes="https://oapi.dingtalk.com/auth/scopes?access_token={$Token}";
        $Scopes = json_decode(file_get_contents($Url_Scopes));
        $Scopes_list = $Scopes->auth_org_scopes->authed_dept;
        //获取授权部门信息
        $Department_Data =array();
        foreach($Scopes_list as $Did){
            $length = count($Department_Data);
            $Url_department ="https://oapi.dingtalk.com/department/get?access_token={$Token}&id={$Did}";
            $Department = json_decode(file_get_contents($Url_department));
            $Department_Data[$length]['dep_id']=$Department->id;
            $Department_Data[$length]['dep_name']=$Department->name;
            $Department_Data[$length]['parentid']=$Department->parentid;
            $Department_Data[$length]['order']=$Department->order;
            //获取子部门
            $Department_Data = $this->get_Sub_department_list($Department_Data,$Department->id,$Token);
        }
        return $Department_Data;
    }

    //子部门
    function get_Sub_department_list($Data,$parentId,$Token){
        $Url_department_list = "https://oapi.dingtalk.com/department/list?access_token={$Token}&&id={$parentId}";
        $SubDepartmentList = json_decode(file_get_contents($Url_department_list));
        $new_data = array();
        if(!empty($SubDepartmentList->department)){
            foreach($SubDepartmentList->department as $key=>$value){
                $new_data[$key]['dep_id']=$value->id;
                $new_data[$key]['dep_name']=$value->name;
                $new_data[$key]['parentid']=$value->parentid;
                $new_data[$key]['order']="";
            }
        }
        $All  = array_merge($Data,$new_data);
        return $All;
    }

    //同步员工信息
    function syn_users ($Token){
        $Users = $this->get_user_list($Token);
//		print_r($Users);
        $M_employee= M('mployee');
        $User_ids =  $M_employee->field('userid')->select();
        if(empty($User_ids)){  //首次同步
            $M_employee->addAll($Users);
        }else{//数据更新
            $Userids  = array_column($User_ids, 'userid');
            $Useridss = array_column($Users, 'userid');
            
            $update = $Users;
            foreach($update as $key=>$item){
                if(in_array($item['userid'],$Userids)){
                    unset($update[$key]);
                }
            }
			//对比本地与钉钉数据，发现不存在的用户进行停用
			foreach ($User_ids as $key => $value) {
				if(!in_array($value['userid'],$Useridss)){
                	$sta = array('status'=>0);
                	$M_employee->where(array('userid'=>"$value[userid]"))->save($sta);
                }
			}
            if(!empty($update)){//新增
                foreach($update as $v){
                    $M_employee->add($v);
                }
            }

            foreach($Users as $user){
                $M_employee->where(array('userid'=>$user['userid']))->save($user);
//				echo $M_employee->_sql();
            }
        }
    }

    //获取全部员工信息
    function get_user_list($Token){
		set_time_limit(0);
    	
        //获取部门所有ID
        $M_Department = M('department');
        $depIds =  $M_Department->field('dep_id')->select();
        $depIds = array_column($depIds, 'dep_id');
        //获取userid和username
        $UsersMessage = $UserId = array();
        foreach($depIds as $key=>$depId){
            $users =  $this->get_user_simpleList($Token,$depId);
            if(!empty($users)){
                foreach($users as $user){
                    if(!in_array($user->userid,$UserId)){
                        $Key = count($UsersMessage);
                        $UsersMessage[$Key][userid] = $user->userid;
                        $UsersMessage[$Key][name] = $user->name;
                        $UserId[] = $user->userid;
                    }
                }
            }
        }
        //员工信息
        foreach($UsersMessage as $key => $user){
            foreach($this->get_user_message($user[userid],$Token) as $k => $v){
                $UsersMessage[$key][$k] = $v;
            }
        }
        return $UsersMessage;
    }

    //获取部门员工的userID、username
    function get_user_simpleList($Token,$departmentId){
        $Url ="https://oapi.dingtalk.com/user/simplelist?access_token={$Token}&department_id={$departmentId}";
        $userMessage = json_decode(file_get_contents($Url))->userlist;
        return $userMessage;
    }

    //获取userI的信息
    function get_user_message($userId,$Token){
        $Url = "https://oapi.dingtalk.com/user/get?access_token={$Token}&userid={$userId}";
         $User_contents = json_decode(file_get_contents($Url));
        //var_dump($User_contents);
        //整理员工信息
        $User_message[mobile] = $User_contents->mobile;//电话
        $User_message[avatar] = $User_contents->avatar;//头像地址
        $User_message[position] = $User_contents->position;//职位
        $User_message[depts] = $User_contents->isLeaderInDepts;//部门权限
        //设置leader默认的当前负责部门ID
        $deps = explode(',',mb_substr($User_message[depts],1,-1));
        if(count($deps)>1){
            foreach($deps as $dep){
                $_dep = explode(':',$dep);
                if($_dep[1] ==='true'){
                    $User_message[dep_now] = $_dep[0];//当前部门
                    break;
                }
            }
        }
        if(empty($User_message[dep_now])){
            $User_message[dep_now] = explode(':',$deps[0])[0];//当前所在部门
        }

       // $User_message[unionid] = $User_contents->unionid;//全局范围内唯一标识一个用户的身份

        return $User_message;
    }
}