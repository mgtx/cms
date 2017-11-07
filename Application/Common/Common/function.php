<?php
/**
 * Created by PhpStorm.
 * User: mgtx
 * Date: 2017/9/8
 * Time: 10:04
 */

//获取access_token
function get_token(){
    $Tiken = M('token');
    $Tokens = $Tiken->where(array('name'=>'access_token'))->find();
    if(empty($Tokens)){//添加授权的access_token
        $Token_data =  get_access_token();
        $Tiken->add($Token_data);
        return $Token_data[token_value];
    }else{
        if(time()-$Tokens[addtime]>7000){//更新授权
            $Token_data =  get_access_token();
            $Tiken->where(array('id'=>$Tokens[id]))->save($Token_data);
            return $Token_data[token_value];
        }else{
            return $Tokens[token_value];
        }
    }
}

/**
 * 获取钉钉授权access_token
 * @return array
 */
function get_access_token(){
    //请求的url地址
    $get_token_url = C('OAPI_HOST')."/gettoken?corpid=".C('CorpId')."&corpsecret=".C('CorpSecret');
    $accessToken= json_decode(file_get_contents($get_token_url));
	
    $Token_data = array();
    $Token_data['name'] = 'access_token';
    $Token_data['token_value'] = $accessToken->access_token;
    $Token_data['addtime'] = time();
    return $Token_data;
}



/**
 * @param $Token            授权token
 * @param $start_time       开始时间
 * @param int $cursor       分页查询的游标
 * @param int $size         分页参数，每页大小，最多传10
 * @param $status           是否递归查询true/flase
 * @return array|null
 */
function get_ding_talk_list($Token,$start_time,$end_time='',$cursor=0,$size=10,$status=true){
    $ding_talk_list= C('ECO_HOST')."?method=".C('Method')."&session={$Token}&v=2.0&format=json&process_code=".C('ProcessCode');
    $ding_talk_list .="&start_time={$start_time}&cursor={$cursor}&size={$size}";
    if(!empty($end_time)){
        $ding_talk_list.="&end_time={$end_time}";
    }
    $_contents = json_decode(file_get_contents($ding_talk_list));
    //整理数据
    $items = $_contents->dingtalk_smartwork_bpms_processinstance_list_response->result->result->list->process_instance_top_vo;//
    //分页查询的游标，最开始传0，后续传返回参数中的next_cursor值
    $next_cursor = $_contents->dingtalk_smartwork_bpms_processinstance_list_response->result->result->next_cursor;
    //var_dump($items[0]->form_component_values->form_component_value_vo);die;
    if(!empty($items)){
        $business = array();
        foreach($items as $key=>$item){
            $business[$key][userid] = $item->originator_userid;
            $business[$key][process_id] = $item->process_instance_id;                       //审批ID
            $business[$key][title] = $item->title;                                          //标题
            $business[$key][status] = $item->status;                                        //审批状态
            $business[$key][process_result] = $item->process_instance_result;               //审批结果
            $business[$key][create_time] = $item->create_time;                              //开始时间,微秒
            $business[$key][finish_time] = isset($item->finish_time)?$item->finish_time:''; //结束时间,微秒
            //提交表单数据
            foreach($item->form_component_values->form_component_value_vo as $value){
                switch($value->name){
                    case '单位名称':
                        $business[$key][units_name] = $value->value?$value->value:'';
                        break;
                    case '收款方式':
                        $business[$key][payment] = $value->value?$value->value:'';
                        break;
                    case '收款原因':
                        $business[$key][cause] = $value->value?$value->value:'';
                        break;
                    case '产品版本':
                        $business[$key][version] = $value->value?$value->value:'';
                        break;
                    case '类型':
                        $business[$key][type] = $value->value?$value->value:'';
                        break;
                    case '用户数':
                        $business[$key][user_num] = $value->value?$value->value:'';
                        break;
                    case '年限':
                        $business[$key][age_limit] = $value->value?$value->value:'';
                        break;
                    case '折扣':
                        $business[$key][discount] = $value->value?$value->value:'';
                        break;
                    case '收款金额':
                        $business[$key][money] = $value->value?$value->value:'';
                        break;
                    case '备注':
                        $business[$key][remarks] = $value->value?$value->value:'';
                        break;
                }
            }

        }
        if($status===true){//为true递归

            if(!empty($next_cursor)){
                $_business = get_ding_talk_list($Token,$start_time,$end_time,$next_cursor,$size,true);

                if(!empty($_business)){
                    return array_merge($business,$_business);
                }
                return $business;

            }else{
                return $business;
            }

        }else{//flase不递归
            return $business;
        }


    }else{
        return null;
    }
}


/**
 * @param $Token            授权token
 * @param $start_time       开始时间
 * @param int $cursor       分页查询的游标
 * @param int $size         分页参数，每页大小，最多传10
 * @param $status           是否递归查询true/flase
 * @return array|null
 */
function get_ding_refund_list($Token,$start_time,$end_time='',$cursor=0,$size=10,$status=true){
    $ding_talk_list= C('ECO_HOST')."?method=".C('Method')."&session={$Token}&v=2.0&format=json&process_code=".C('tProcessCode');
    $ding_talk_list .="&start_time={$start_time}&cursor={$cursor}&size={$size}";
    if(!empty($end_time)){
        $ding_talk_list.="&end_time={$end_time}";
    }
    $_contents = json_decode(file_get_contents($ding_talk_list));
    //整理数据
    $items = $_contents->dingtalk_smartwork_bpms_processinstance_list_response->result->result->list->process_instance_top_vo;//
    //分页查询的游标，最开始传0，后续传返回参数中的next_cursor值
    $next_cursor = $_contents->dingtalk_smartwork_bpms_processinstance_list_response->result->result->next_cursor;
    //var_dump($items[0]->form_component_values->form_component_value_vo);die;
    if(!empty($items)){
        $business = array();
        foreach($items as $key=>$item){
            $business[$key][userid] = $item->originator_userid;
            $business[$key][process_id] = $item->process_instance_id;                       //审批ID
            $business[$key][title] = $item->title;                                          //标题
            $business[$key][status] = $item->status;                                        //审批状态
            $business[$key][process_result] = $item->process_instance_result;               //审批结果
            $business[$key][create_time] = $item->create_time;                              //开始时间,微秒
            $business[$key][finish_time] = isset($item->finish_time)?$item->finish_time:''; //结束时间,微秒
            //提交表单数据
            foreach($item->form_component_values->form_component_value_vo as $value){
                switch($value->name){
                    case '单位名称':
                        $business[$key][units_name] = $value->value?$value->value:'';
                        break;
                    case '收款方式':
                        $business[$key][payment] = $value->value?$value->value:'';
                        break;
                    case '产品':
                        $business[$key][cause] = $value->value?$value->value:'';
                        break;
                    case '产品版本':
                        $business[$key][version] = $value->value?$value->value:'';
                        break;
                    case '类型':
                        $business[$key][type] = $value->value?$value->value:'';
                        break;
//                  case '用户数':
//                      $business[$key][user_num] = $value->value?$value->value:'';
//                      break;
                    case '年限':
                        $business[$key][age_limit] = $value->value?$value->value:'';
                        break;
                    case '折扣':
                        $business[$key][discount] = $value->value?$value->value:'';
                        break;
                    case '退款金额（元）':
                        $business[$key][money] = $value->value?-$value->value:'';
                        break;
                    case '退款原因':
                        $business[$key][remarks] = $value->value?$value->value:'';
                        break;
                }
            }

        }
        if($status===true){//为true递归

            if(!empty($next_cursor)){
                $_business = get_ding_refund_list($Token,$start_time,$end_time,$next_cursor,$size,true);

                if(!empty($_business)){
                    return array_merge($business,$_business);
                }
                return $business;

            }else{
                return $business;
            }

        }else{//flase不递归
            return $business;
        }


    }else{
        return null;
    }
}

/**
 * 根据userid获取用户信息，以及所在组的成员信息
 * @param $usrid  用户的唯一ID标识
 */
function get_user_Message_leader_member(array $userids){
    $M_mployee = M('mployee');
//			print_r($userids);die();
    $M_department = M('department');
    foreach($userids as $id){
        $userMessages[$id] = $M_mployee->where("userid='{$id}'")->field('userid,name,dep_now,avatar')->find();
		if($userMessages[$id]['userid']){
			if($userMessages[$id]['avatar']==''){
	            $userMessages[$id]['avatar'] = PUBLIC_IMAGE."default_head.png";
	        }
	        //部门
	        $userMessages[$id][dep_name] = $M_department->where(array('dep_id'=>$userMessages[$id][dep_now]))->field('dep_name')->find()[dep_name];
	        //部门leader
	        $str_leader =  $userMessages[$id][dep_now].":true";
	        $where['depts'] = array('like', "%$str_leader%");
	        $userMessages[$id][leader] = implode(',',array_column($M_mployee->where($where)->field('name')->select(),'name'));
		}else{
			unset($userMessages[$id]);
		}
    }

    return $userMessages;
}

/**
 * curl请求群机器人
 * @param $remote_server  钉钉群机器人的webhook
 * @param $post_string    发送的内容（例：array('msgtype' => 'text','text' => array ('content' => $message),'isAtAll'=>true)，详见文档）
 * @param string $SSLfile SSL本地协议地址
 * @return mixed
 */
function request_by_curl($remote_server, $post_string,$SSLfile='') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if(!empty($SSLfile)){
        // 为保证第三方服务器之间数据传输的安全性，所有接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch,CURLOPT_CAINFO,$SSLfile);//这是根据http://curl.haxx.se/ca/cacert.pem 下载的证书，添加这句话之后就运行正常了
    }else{
        // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
    }

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

//获取某产品销售排名
function get_personage_products_ranking($cause=null,$time=null,$between=false ){
    $M_business = M('business');

    if(empty($cause)){
        if(!empty($time)){
            if($between){
                $_sql = "SELECT cause,SUM(B.money) AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' AND B.create_time >= '{$time}' GROUP BY cause";

            }else{
                $_sql = "SELECT cause,SUM(B.money) AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' AND B.create_time LIKE '{$time}%' GROUP BY cause";
            }
        }else{
            $_sql = "SELECT cause,SUM(B.money) AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' GROUP BY cause";
        }

        $date = $M_business->query($_sql);
        array_multisort(array_column($date,'sum'), SORT_DESC,$date);//总业绩排序

    }else{

        //个人
        if(!empty($time)){
            if($between){
                $_sql = "SELECT userid,SUM(B.money)AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' AND cause='{$cause}' AND B.create_time >= '{$time}' GROUP BY userid";

            }else{
                $_sql = "SELECT userid,SUM(B.money)AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' AND cause='{$cause}' AND B.create_time LIKE '{$time}%' GROUP BY userid";
            }
        }else{
            $_sql = "SELECT userid,SUM(B.money)AS sum FROM mgtx_business AS B WHERE B.process_result = 'agree' AND cause='{$cause}' GROUP BY userid";
        }

        $personage = $M_business->query($_sql);

        foreach($personage as $key=>$value){
            $userId = array($value[userid]);
            $msg = get_user_Message_leader_member($userId);
            //$date[$key] = array_merge($date[$key],$msg[$value[userid]]);
            $personage[$key][name] =$msg[$value[userid]][name];
            $personage[$key][dep_id] =$msg[$value[userid]][dep_now];
            $personage[$key][dep_name] =$msg[$value[userid]][dep_name];
        }

        array_multisort(array_column($personage,'sum'),SORT_DESC,$personage);//个人排序

        //部门
        $dep_ids = array_unique(array_column($personage,'dep_id')) ;
        $dep_names = array_column($personage,'dep_name');

        foreach($dep_ids as $k => $id){
            $department[$k][dep_id] = $id;
            $department[$k][dep_name] = $dep_names[$k];
            foreach($personage as $per){
                if($id == $per['dep_id']){
                    if($department[$k][sum]){
                        $department[$k][sum] +=$per[sum];
                    }else{
                        $department[$k][sum] =$per[sum];
                    }
                }
            }
        }

        array_multisort(array_column($department,'sum'), SORT_DESC,$department);//部门排序

        $date[personage] = $personage;
        $date[department] = $department;
    }
    return $date;
}



/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $count 要分页的总记录数
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage($count, $pagesize = 10) {
    $p = new Think\Page($count, $pagesize);
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $p->lastSuffix = false;//最后一页不显示为总页数
    return $p;
}