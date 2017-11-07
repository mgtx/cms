<?php/** * Created by PhpStorm. * User: milo * Date: 15/3/23 * Time: 14:05 */namespace Admin\Controller;use Think\Controller;class StatisticalController extends AuthController{	//所有统计	function allStatistical(){		$all = $this->M_yearTarget->select();		if($all){			$_date[sum] = array_sum(array_column($all,'complete'));		}else{			$_date[sum] = 0;		}		//不同产品的全部业绩		$_date[products] = get_personage_products_ranking();		//不同产品的个人业绩默认排名第的		if(!empty($_date[products])){			$Return = get_personage_products_ranking($_date[products][0][cause]);			$_date[personage] = $Return[personage];			$_date[department] = $Return[department];		}else{			$_date[personage] = '';			$_date[department] = '';		}		//部门总业绩		$team_target = $this->M_business_target_team->select();		if($team_target){			$team_id= array_unique(array_column($team_target,'dep_id'));			$team_name = array_unique(array_column($team_target,'dep_name'));			foreach($team_id as $k => $id){				$_date[team_target][$k][dep_id] =$id;				$_date[team_target][$k][dep_name] =$team_name[$k];				foreach($team_target as $value){					if($id == $value['dep_id']){						if($_date[team_target][$k][sum]){							$_date[team_target][$k][sum] +=$value[complete];						}else{							$_date[team_target][$k][sum] =$value[complete];						}					}				}			}			array_multisort(array_column($_date[team_target],'sum'), SORT_DESC,$_date[team_target]);//部门排序		}else{			$_date[team_target] = '';		}		//个人总业绩		$personage_target = $this->M_business_target_personage->select();		if($personage_target){			$personage_id	= array_unique(array_column($personage_target,'userid'));			$personage_name = array_unique(array_column($personage_target,'name'));			foreach($personage_id as $k => $id){				$_date[per_target][$k][userid] =$id;				$_date[per_target][$k][name] =$personage_name[$k];				foreach($personage_target as $value){					if($id == $value['userid']){						if($_date[per_target][$k][sum]){							$_date[per_target][$k][sum] +=$value[complete];						}else{							$_date[per_target][$k][sum] =$value[complete];						}					}				}			}			array_multisort(array_column($_date[per_target],'sum'), SORT_DESC,$_date[per_target]);//部门排序		}else{			$_date[per_target] = '';		}		$this->assign('title_pre','');		$this->assign('_date',$_date);		$this->assign('Syn',$_SESSION['Syn']);		$this->display();	}	//当月统计	function monthStatistical(){		$month = date('Y-m');		//当月完成额		$month_target = $this->M_monthTarget->where("month='{$month}'")->find();		if($month_target){			$_date[sum] = $month_target[complete];		}else{			$_date[sum]= 0;		}		//不同产品的当月业绩		$_date[products] = get_personage_products_ranking('',$month);		//不同产品的个人当月业绩默认排名第1的		if(!empty($_date[products])){			$Return = get_personage_products_ranking($_date[products][0][cause],$month);			$_date[personage] = $Return[personage];			$_date[department] = $Return[department];		}else{			$_date[personage] = '';			$_date[department] = '';		}		//当月部门总业绩		$field = "dep_id,dep_name,complete as sum";		$_date[team_target] = $this->M_business_target_team->where(array('month'=>$month))->field($field)->select();		array_multisort(array_column($_date[team_target],'sum'), SORT_DESC,$_date[team_target]);//部门排序		//当月个人总业绩		$field = "userid,name,complete as sum";		$_date[per_target] = $this->M_business_target_personage->where(array('month'=>$month))->field($field)->select();		array_multisort(array_column($_date[per_target],'sum'), SORT_DESC,$_date[per_target]);//部门排序		$this->assign('title_pre','当月');		$this->assign('_date',$_date);		$this->assign('Syn',$_SESSION['Syn']);		$this->display();	}	//近3月统计	function quarterYearStatistical(){		$month 		 = date('Y-m');		$middle_time = date("Y-m",strtotime("-1 months",strtotime($month)));		$start_time  = date("Y-m",strtotime("-2 months",strtotime($month)));		$month_target = $this->M_monthTarget->where("month >='{$start_time}'")->field('SUM(complete) as sum')->find();		//var_dump($this->M_monthTarget->getLastSql());		if($month_target){			$_date[sum] = $month_target[sum];		}else{			$_date[sum]= 0;		}		//近3月不同产品的当月业绩		$_date[products] = get_personage_products_ranking('',$start_time,true);		//近3月不同产品的个人当月业绩默认排名第1的		if(!empty($_date[products])){			$Return = get_personage_products_ranking($_date[products][0][cause],$start_time,true);			$_date[personage] = $Return[personage];			$_date[department] = $Return[department];		}else{			$_date[personage] = '';			$_date[department] = '';		}		//近3月部门总业绩		$team_sql = "SELECT dep_id,dep_name,SUM(T.complete) AS sum FROM mgtx_business_target_team AS T WHERE ";		$team_sql .="month = '{$month}%' OR month = '{$middle_time}' OR month = '{$start_time}' GROUP BY dep_id";		$_date[team_target] = $this->M_business_target_team->query($team_sql);		array_multisort(array_column($_date[team_target],'sum'), SORT_DESC,$_date[team_target]);//部门排序		//近3月个人总业绩		$per_sql = "SELECT userid,name,SUM(P.complete) AS sum FROM mgtx_business_target_personage AS P WHERE ";		$per_sql .="month = '{$month}' OR month = '{$middle_time}' OR month = '{$start_time}' GROUP BY userid";		$_date[per_target] = $this->M_business_target_personage->query($per_sql);		array_multisort(array_column($_date[per_target],'sum'), SORT_DESC,$_date[per_target]);		$this->assign('title_pre','近三月');		$this->assign('_date',$_date);		$this->assign('Syn',$_SESSION['Syn']);		$this->display();	}	//今年统计	function thisYearStatistical(){		$year = date('Y');		//今年完成额		$year_target = $this->M_yearTarget->where("year='{$year}'")->find();		if($year_target){			$_date[sum] = $year_target[complete];		}else{			$_date[sum]= 0;		}		//今年不同产品的当月业绩		$_date[products] = get_personage_products_ranking('',$year);		//今年不同产品的个人当月业绩默认排名第1的		if(!empty($_date[products])){			$Return = get_personage_products_ranking($_date[products][0][cause],$year);			$_date[personage] = $Return[personage];			$_date[department] = $Return[department];		}else{			$_date[personage] = '';			$_date[department] = '';		}		//今年部门总业绩		$team_sql = "SELECT dep_id,dep_name,SUM(P.complete) AS sum FROM mgtx_business_target_team AS P WHERE ";		$team_sql .="month LIKE '{$year}%' GROUP BY dep_id";		$_date[team_target] = $this->M_business_target_team->query($team_sql);		array_multisort(array_column($_date[team_target],'sum'), SORT_DESC,$_date[team_target]);//部门排序		//今年个人总业绩		$per_sql = "SELECT userid,name,SUM(P.complete) AS sum FROM mgtx_business_target_personage AS P WHERE ";		$per_sql .="month LIKE '{$year}%' GROUP BY userid";		$_date[per_target] = $this->M_business_target_personage->query($per_sql);		array_multisort(array_column($_date[per_target],'sum'), SORT_DESC,$_date[per_target]);		$this->assign('title_pre','今年');		$this->assign('_date',$_date);		$this->assign('Syn',$_SESSION['Syn']);		$this->display();	}	//近三年统计	function threeYearStatistical(){		$year 		 = date('Y');		$middle_time = date("Y",strtotime("-1 year",strtotime($year)));		$start_time  = date("Y",strtotime("-2 year",strtotime($year)));		//近三年完成额		$year_target = $this->M_yearTarget->where("year >='{$start_time}'")->field('SUM(complete) as sum')->find();		//var_dump($year_target);		if($year_target){			$_date[sum] = $year_target[sum];		}else{			$_date[sum]= 0;		}		/*//近三年不同产品的当月业绩		$_date[products] = get_personage_products_ranking('',$year,true);		//近三年不同产品的个人当月业绩默认排名第1的		if(!empty($_date[products])){			$Return = get_personage_products_ranking($_date[products][0][cause],$year,true);			$_date[personage] = $Return[personage];			$_date[department] = $Return[department];		}else{			$_date[personage] = '';			$_date[department] = '';		}*/		//近三年部门总业绩		$team_sql = "SELECT dep_id,dep_name,SUM(T.complete) AS sum FROM mgtx_business_target_team AS T WHERE ";		$team_sql .="month LIKE '{$year}%' OR month LIKE '{$middle_time}%' OR month LIKE '{$start_time}%' GROUP BY dep_id";		$_date[team_target] = $this->M_business_target_team->query($team_sql);		array_multisort(array_column($_date[team_target],'sum'), SORT_DESC,$_date[team_target]);//部门排序		//近三年个人总业绩		$per_sql = "SELECT userid,name,SUM(P.complete) AS sum FROM mgtx_business_target_personage AS P WHERE ";		$per_sql .="month LIKE '{$year}%' OR month LIKE '{$middle_time}%' OR month LIKE '{$start_time}%' GROUP BY userid";		$_date[per_target] = $this->M_business_target_personage->query($per_sql);		array_multisort(array_column($_date[per_target],'sum'), SORT_DESC,$_date[per_target]);		$this->assign('title_pre','近三年');		$this->assign('_date',$_date);		$this->assign('Syn',$_SESSION['Syn']);		$this->display();	}		//业绩修改	function update_team_performance(){		$M_money_log = M('money_log m');		$M_department = M('department d');		if(IS_AJAX){			$M_business_target_team = M('business_target_team');			$newteam = I('get.newteam');			$log_id  = I('get.log_id');
			$log_info = $M_money_log->where("id= '$log_id'")->find();			$M_money_log->where("id=$log_id")->save(array('dep_id'=>$newteam));			$time = date('Y-m',$log_info['date']);			$where = array(				'month'=>$time,
				'dep_id'=>$log_info['dep_id'],			);			$w = array(				'month'=>$time,				'dep_id'=>$newteam,			);			$M_business_target_team->where($where)->setDec('complete',$log_info['money']);			$M_business_target_team->where($w)->setInc('complete',$log_info['money']);//			echo $M_business_target_team->_sql();
			die(0);		}else{			$page  = I('page');			$last_month = strtotime(date("Y-m-1 0:0:0",strtotime('- 1 month')));
            $month = time();			$count = $M_money_log->join('__BUSINESS__ b ON m.process_id = b.process_id')						->where("m.date between '{$last_month}' AND '{$month}'")						->count();			$p = getpage($count,20);			$temp = $M_department->select();			$dep = '';			foreach ($temp as $key => $value) {
				$dep .= "<option value='$value[dep_id]'>".$value['dep_name']."</option>";			}			$data = $M_money_log->join('__BUSINESS__ b ON m.process_id = b.process_id')						->join('__DEPARTMENT__ d ON m.dep_id = d.dep_id')						->field("m.*,b.units_name units_name,b.cause cause,b.create_time create_time, d.dep_name dep_name")						->where("m.date between '{$last_month}' AND '{$month}'")						->order('m.date desc')						->limit($p->firstRow, $p->listRows)						->select();			$this->assign('page', $p->show());			$this->assign('data',$data);			$this->assign('dep',$dep);
						$this->display();		}	}	function get_product(){		if(IS_AJAX){			$date = array();			$product = I('product');			$type = I('type');			$year 		 = date('Y');			$month 		 = date('Y-m');			$start_time  = date("Y-m",strtotime("-2 months",strtotime($month)));			switch($type){				case '当月':					$All = get_personage_products_ranking($product,$month);					break;				case '近三月':					$All = get_personage_products_ranking($product,$start_time,true);					$s = $this->M_business->getLastSql();					break;				case '今年':					$All = get_personage_products_ranking($product,$year);					break;				default:					$All = get_personage_products_ranking($product);			}			if($All){				$code = 0;				$msg = '获取成功';				$date['list'] = $All;			}else{				$code = -1;				$msg = '获取失败';			}			$date['code'] = $code;			$date['msg'] = $msg;			$date['s'] = $s;			$this->Ajaxreturn($date);		}		$this->Ajaxreturn(array('code'=>-1,'msg'=>'无效访问'));	}}