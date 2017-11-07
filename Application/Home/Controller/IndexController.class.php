<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public $M_select_time;
    public $M_business;
    public $M_yearTarget;
    public $M_monthTarget;
    public $M_business_target_team;
    public $M_business_target_personage;
    public $M_dep;
    public $M_mployee;
    public $M_last_update;

    function __construct()
    {
        parent::__construct();
        $this->M_select_time = M('select_time');
        $this->M_business = M('business');
        $this->M_yearTarget = M('business_target_year');
        $this->M_monthTarget = M('business_target_month');
        $this->M_business_target_team = M('business_target_team');
        $this->M_business_target_personage = M('business_target_personage');
        $this->M_money_log = M('money_log');
        $this->M_dep =  M('department');
        $this->M_mployee =  M('mployee');
        $this->M_last_update =  M('last_update');
    }



    public function index(){

        //验证后台是否已经同步数据
        if(empty($this->M_dep->select())||empty($this->M_mployee->select())){

            $this->success('您还未同步任何部门和员工信息，请先到后台同步信息.',U('/Admin'),2);

        }else{
           // echo strtotime('2017-09-28 11:59:06');
            $year = date("Y");
            $month = date("Y-m");
			$last_month = date("Y-m",strtotime('- 1 month'));
			$getmonth = $_GET['month'] == 2?2:1;
            $index_date['year_target'] = $this->M_yearTarget->where(array("year='{$year}'"))->find();
            $index_date['month_target'] = $this->M_monthTarget->where(array("month='{$month}'"))->find();

            $index_date['year_target']  = $this->collating($index_date['year_target']);
            $index_date['month_target'] = $this->collating($index_date['month_target']);
            //剩余天数
            $index_date['surplus_day'] =date("t",time())- date('j')+1;

            $_date = $this->M_last_update->select();
			
            $personage  = $this->M_business_target_personage->where("month='{$month}'")->select();
			
			$not_id = array();
			foreach ($personage as $key => $value) {
				$not_id[] = $value['userid'];
			}

			$not_id = implode(',',$not_id);
			$n_user = $this->M_mployee->where("userid not in ($not_id) ")->field('name,userid')->select();

			$personage = array_merge($personage,$n_user);
            foreach($personage as $k=>$val){
                $personage[$k] =  $this->collating($val);
				if(!isset($val['complete'])){
            		$personage[$k]['complete'] = 0;
            	}
            }
			
			
			$personage2  = $this->M_business_target_personage->where("month in('{$month}','{$last_month}')")->select();
			$temparr = array('obj'=>array(),'uid'=>array());
            foreach($personage2 as $k=>$val){
            	if(!in_array($val['userid'], $temparr['uid'])){
            		$temparr['uid'][] = $val['userid'];
					$temparr['obj'][$val['userid']] = $val;
            	}else{
            		$temparr['obj'][$val['userid']]['complete'] = $temparr['obj'][$val['userid']]['complete']+$val['complete'];
            	}
            }
			
            array_multisort(array_column($personage,'complete'), SORT_DESC,$personage);
            array_multisort(array_column($temparr['obj'],'complete'), SORT_DESC,$temparr['obj']);
            
            $team       = $this->M_business_target_team->where("month='{$month}'")->select();
            foreach($team as $key=>$value){
                $team[$key] =  $this->collating($value);
            }
			
            $team2       = $this->M_business_target_team->where("month in('{$month}','{$last_month}')")->select();
			$temparr2 = array('obj'=>array(),'dep_id'=>array());
//			print_r($team2);
            foreach($team2 as $ke=>$va){

            	if(!in_array($va['dep_id'], $temparr2['dep_id'])){

            		$temparr2['dep_id'][] = $va['dep_id'];
//					print_r($va);
					$temparr2['obj'][$va['dep_id']] = $va;
            	}else{
            		$temparr2['obj']["$va[dep_id]"]['leader'] = $va['leader'];
            		$temparr2['obj']["$va[dep_id]"]['complete'] = $temparr2['obj']["$va[dep_id]"]['complete']+$va['complete'];
            	}
            }
//print_r($temparr2);
			
            array_multisort(array_column($team,'complete'), SORT_DESC,$team);//部门排序
            array_multisort(array_column($temparr2['obj'],'complete'), SORT_DESC,$temparr2['obj']);//部门排序
            $this->assign('index_date',$index_date);//轮播
            $this->assign('dep_date',$_date);       //轮播业绩
            if($getmonth == 1){
            	$this->assign('dep_per',$personage);    //个人排名
            	$this->assign('dep_team',$team);        //部门排名
			}else{
            	$this->assign('dep_per_2',$temparr);    //前两月个人排名
            	$this->assign('dep_team_2',$temparr2);        //部门排名
			}

            $this->assign('getmonth',$getmonth);    
            

            $this->display();
        }
    }

    //整理
    function collating($date){
        if($date['target']==0){
            $date['target'] = '未设置';
            $date['surplus'] = 0;
            $date['flg'] = '未设置';
        }else{
            if($date['target'] > $date['complete']){
                $date['surplus'] = $date['target'] - $date['complete'];
                $date['flg'] = '未完成';
            }else{
                $date['surplus'] = 0;
                $date['flg'] = '已完成';
            }
        }

        return $date;
    }

    //定时执行任务
    function Syn_business(){
        $_date = array();//需要回传数组
        $Token = get_token();

        //获取查询时间并更新时间下次获取时间
        //$startTime = 0;
        $startTime = $this->get_select_time();
        //查询更新审批状态分为NEW|RUNNING运行中的是否更新
        $syn_business = $this->M_business->where("(status='RUNNING' or status='NEW') AND approve_type = 1")->field(array('process_id','create_time'))->select();
        if(!empty($syn_business)){
            $syn_business_date = array();
            foreach($syn_business as $key => $item){
                $syn_start_time = strtotime($item['create_time'])*1000;//毫秒
                $talk_list = get_ding_talk_list($Token,$syn_start_time,$syn_start_time,0,1,flase);
                $syn_business_date[$key] = $talk_list[0];
            }
            if(!empty($syn_business_date)){
                foreach($syn_business_date as $k=> $item){
                    //需返回的数据
                    if($item['process_result']=='agree'){
                        $business_date[] = $item;
                    }
                    //更新数据
                    $this->M_business->where($syn_business[$k])->save($item);
                }

            }
        }

        //常规拉取数据
        $data_list = get_ding_talk_list($Token,$startTime);

        //新增数据
        if(!empty($data_list)){
            foreach($data_list as $k=>$item){
                if($item['process_result']=='agree'){
                    $business_date[]= $item;
                }
				$id = $this->M_business->where("process_id='{$item[process_id]}'")->field('id')->find();

                if(!$id['id']){
                    $this->M_business->add($item);
                }
            }
        };

        //个人成交业务展示数据
        if(!empty($business_date)){
            $usreIds = array_unique((array_column($business_date,'userid')));
            $user_message = get_user_Message_leader_member($usreIds);

            $keys = array('cause','version','type','user_num','age_limit','money','create_time','process_id');
            foreach($business_date as $key => $value){
                $_date[$key] = $user_message[$value['userid']];
                foreach($keys as $k){
                    $_date[$key][$k] = $value[$k];
                }
            }
        }
//
//      //存储最更新的业绩
////      if(!empty($_date)){
////         
////			$show = '';
////			foreach($_date as $value){
////				if($value[type] == '新开'){
////					$show[] = $value;
////				}
////			}
////			if(!empty($show)){
////				$return = $this->M_last_update->find();
////				if($return){
////              //清空表格
////              $_sql = 'truncate table mgtx_last_update';
////              $this->M_last_update->execute($_sql);
////				}
////				$this->M_last_update->addAll($show);
////				//调用群机器人
////				$this->toRobot($show);
////			} 
////      }
//
        //统计年月总业绩完成额
        $this->Syn_year_month_target($_date);
        //统计团队和个人业绩
        $this->Syn_team_personage_target($_date);
		
		
		
		//退款审批业绩处理
		$syn_refund = $this->M_business->where("(status='RUNNING' or status='NEW') AND approve_type = 2")->field(array('process_id','create_time'))->select();
        if(!empty($syn_refund)){
            $syn_refund_date = array();
            foreach($syn_refund as $key => $item){
                $syn_start_time = strtotime($item['create_time'])*1000;//毫秒
                $refund_list = get_ding_refund_list($Token,$syn_start_time,$syn_start_time,0,1,flase);
                $syn_refund_date[$key] = $refund_list[0];
            }
            if(!empty($syn_refund_date)){
                foreach($syn_refund_date as $k=> $item){
                    //需返回的数据
                    if($item['process_result']=='agree'){
                        $refund_date[] = $item;
                    }
                    //更新数据
                    $this->M_business->where($syn_refund[$k])->save($item);
                }

            }
        }
        $data_refund = get_ding_refund_list($Token,$startTime);
//		print_r($data_refund);die();
		//      //新增数据
        if(!empty($data_refund)){
            foreach($data_refund as $ke=>$va){
                if($va['process_result']=='agree'){
                    $refund_date[]= $va;
                }
				$id = $this->M_business->where("process_id='{$va[process_id]}'")->field('id')->find();

                if(!$id['id']){
                	$va['approve_type'] = 2;
                    $this->M_business->add($va);
                }
            }
        };
		
		 //个人成交业务展示数据
        if(!empty($refund_date)){
            $usreIds = array_unique((array_column($refund_date,'userid')));
            $user_message = get_user_Message_leader_member($usreIds);

            $keys = array('cause','version','type','user_num','age_limit','money','create_time','process_id');
			$_date = array();
            foreach($refund_date as $key => $value){
                $_date[$key] = $user_message[$value['userid']];
                foreach($keys as $k){
                    $_date[$key][$k] = $value[$k];
                }
            }
        }
		//统计年月总业绩完成额
        $this->Syn_year_month_target($_date);
//      //统计团队和个人业绩
        $this->Syn_team_personage_target($_date);
		
        exit('结束');
    }

    //获取查询时间
    function get_select_time(){

        $new_last_time = time()*1000;
        $start_time =  $this->M_select_time->find();

        if(empty($start_time)){
            $startTime = 0;
            $this->M_select_time -> add(array('last_time'=>$new_last_time));
        } else{
            $startTime = $start_time['last_time'];
            $start_time['last_time'] = $new_last_time;
            $this->M_select_time -> save($start_time);
        }

        return $startTime;
    }


    function Syn_year_month_target($_date){

        $year = date('Y');
        $month = date('Y-m');

        //获取今年的年目标
        $year_target = $this->M_yearTarget->where(array("year"=>"{$year}"))->find();
        if(empty($year_target)){
            $this->M_yearTarget->add(array('year'=>"{$year}"));
            $year_target = $this->M_yearTarget->where("year='{$year}'")->find();
        }

        if($year_target['complete']==0){
            //首次统计本年业绩
            $year_agree= $this->M_business->where(array("process_result='agree' and create_time like '{$year}%'"))->field("SUM(money) as sum")->select();
			$year_money = $year_agree[0];
            if(!empty($year_money['sum'])){
                $this->M_yearTarget->where("year='{$year}'")->setInc('complete',$year_money['sum']);
            }

        }else{
            //年业绩叠加
            if(!empty($_date)){
                foreach($_date as $item){
                    if($item['money'] != 0){
                        $create_year = substr($item['create_time'],0,4);
                        $this->M_yearTarget->where("year='{$create_year}'")->setInc('complete',$item['money']);
                    }

                }
            }
        }

        //获取当月总目标
        $month_target = $this->M_monthTarget->where("month='{$month}'")->find();
        if(empty($month_target)){
            $this->M_monthTarget->add(array('month'=>"{$month}"));
            $month_target = $this->M_monthTarget->where("month='{$month}'")->find();
        }

        if($month_target['complete']==0){
            $month_agree= $this->M_business->where(array("process_result='agree' and create_time like '{$month}%'"))->field("SUM(money) as sum")->select();//全部审批通过的业务数据
            $month_money = $month_agree[0];
            if(!empty($month_money['sum'])){
                $this->M_monthTarget->where("month='{$month}'")->setInc('complete',$month_money['sum']);
            }

        }else{
            if(!empty($_date)){
                foreach($_date as $item){
                    if($item['money'] != 0) {
                        $create_time = substr($item['create_time'], 0, 7);
                        $this->M_monthTarget->where("month='{$create_time}'")->setInc('complete', $item['money']);

                    }
                }
            }
        }
    }


    function Syn_team_personage_target($_date){

        if($_date){
            foreach($_date as $item){
//          	print_r($item);
                //var_dump($item);
                $create_month       =   substr($item['create_time'],0,7);

                $where_team         =   array('dep_id'=>$item['dep_now'],'month'=>$create_month);
                $status = $this->M_dep->where("dep_id={$item[dep_now]}")->field('status')->find();
//				echo $this->M_dep->_sql();
                if($status['status']== 0){
                    $status['status'] = 1;
                    $this->M_dep->where("dep_id={$item[dep_now]}")->save($status);
                }

                $where_personage    =   array('userid'=>$item['userid'],'month'=>$create_month);

                $team_target        =   $this->M_business_target_team->where($where_team)->find();
                $personage_target   =   $this->M_business_target_personage->where($where_personage)->find();

                if(empty($team_target)){
                    $where_team['dep_name'] = $item['dep_name'];
                    $where_team['leader'] = $item['leader'];
                    $this->M_business_target_team->add($where_team);
                }

                if(empty($personage_target)){
                    $where_personage['name'] = $item['name'];
                    $this->M_business_target_personage->add($where_personage);
                }

                if($item[money] != 0){
                    //team_target
                    $this->M_business_target_team->where($where_team)->setInc('complete',$item[money]);

                    //personage_target
                    $this->M_business_target_personage->where($where_personage)->setInc('complete',$item[money]);
		set_time_limit(0);
					if(!$this->M_money_log->where("process_id = '$item[process_id]'")->find()){
						$w = array(
							'userid' 	=> $item[userid],
							'name'	 	=> $item[name],
							'date'	 	=> strtotime($item[create_time]),
							'money'	 	=> $item[money],
							'dep_id' 	=> $item[dep_now],
							'process_id'=> $item[process_id]
						);
						$this->M_money_log->add($w);
					}
					
					
                }

            }
        }
    }



    //群机器人
    function toRobot($_date){

        if(!empty($_date)){

            foreach($_date as $item){

                $webhook = C('Webhook');

                $message=<<<EOT
    恭喜
    组员: {$item[name]}, 成交{$item[money]}元
    所属小组:{$item[dep_name]}
    组长:{$item[leader]}
    产品类型:{$item[cause]}
    用户数:{$item[user_num]}用户
    产品型号:{$item[type]}
    产品年限:{$item[age_limit]}
EOT;
                $data = array ('msgtype' => 'text',
                    'text' => array (
                        'content' => $message),
                     "isAtAll"=>true
                );
                $data_string = json_encode($data);
                $SSLfile = C('SSL');
                request_by_curl($webhook,$data_string,$SSLfile);
                sleep(1);
            }
        }
    }

}