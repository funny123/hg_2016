<?php
/*
 * @thinkphp3.2.2  客户管理   php5.3以上
 * @Created on 2015/12/18
 * @Author  funny   524656859@qq.com
 * @如果需要公共控制器，就不要继承AuthController，直接继承Controller
 */
namespace Admin\Controller;
use Think\Controller;
use Org\Util;
use Common\Controller\AuthController;
use Think\Auth;



//后台管理员
class NewMemberController extends Controller
{

    //用户列表
    public function member_list($id=0)
    {
        $m = M('new_member');
        $where = ['status' => 1];
       // $where['status']=1;
        if (I('member')!='') {
            if($_REQUEST['member']=='agentname'){
                $_REQUEST['member']='agentname|agentname_x';
            }
            if(I('member')=='jihuomoney'){  //激活资金区间查询eg:20-200
                $map=explode('-',htmlspecialchars(trim(I('textsearcherkeywords'))));//把-前后分割，切割之后是数组
                $where[$_REQUEST['member']]=[['egt',$map[0]],['elt',$map[1]],'and'];
            }elseif(I('member')=='birthday'){//strpos(string,find,start)
                $birth=strpos(htmlspecialchars(trim(I('textsearcherkeywords'))),'-');
                if($birth){
                    $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
                }else{
                    $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'-'.'%');
                }
            }
            else{
                $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
            }
        }
        //登录时间、激活时间的搜搜
        if (I('timeselect')){
            $where[I('timeselect')]=array(array('egt',strtotime(I('startime').' 00:00:00')),array('elt',strtotime(I('endtime').' 23:59:59'),'and'));
        }
        $order1='id ASC';
        $order=urldecode($_REQUEST['order']);
        $order=($order !='')?$order:$order1;
        $f='id,status';
        $auth=new Auth();
        $g=$auth->getGroups(session('aid'));
        $b=$g[0]['rules'];
        $a=explode(',',$b);
        if(in_array("49",$a))
        {
            $f.=',realname';
        }if(in_array("51",$a))
    {
        $f.=',loginname';
    }if(in_array("52",$a))
    {
        $f.=',codeid';
    }if(in_array("53",$a))
    {
        $f.=',time';
    }if(in_array("54",$a))
    {
        $f.=',sex';
    }if(in_array("55",$a))
    {
        $f.=',tel';
    }if(in_array("56",$a))
    {
        $f.=',agentname';
    }if(in_array("57",$a))
    {
        $f.=',groupname';
    }if(in_array("58",$a))
    {
        $f.=',department';
    }if(in_array("59",$a))
    {
        $f.=',jihuotime';
    }if(in_array("60",$a))
    {
        $f.=',jihuomoney';
    }if(in_array("61",$a))
    {
        $f.=',loginuser';
    }if(in_array("62",$a))
    {
        $f.=',kaihuform';
    }if(in_array("63",$a))
    {
        $f.=',birthday';
    }if(in_array("64",$a))
    {
        $f.=',moniname';
    }
        $f.=',agentname_x';

        $f.=',department_x';
        $f.=',groupname_x';

        $departmentArr = [];
        if(in_array("72",$a))
        {
            $departmentArr[] = 1;
        }
        if(in_array("74",$a)){
            $departmentArr[] = 2;
        }
        if(in_array("75",$a)){
            $departmentArr[] = 3;
        }
        if(in_array("76",$a)){
            $departmentArr[] = 4;
        }
        if(in_array("77",$a)){
            $departmentArr[] = 5;
        }
        if(in_array("78",$a)){
            $departmentArr[] = 6;
        }
        if(in_array("79",$a)){
            $departmentArr[] = 7;
        }
        $departmentArr = implode(',', $departmentArr);
        $where['department_x'] = ['in',$departmentArr];
        $count = $m->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '末页');
        $page->setConfig('first', '首页');
        $page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $show = $page->show();
        $limit = $page->firstRow.','.$page->listRows;
        $lists = $m->where($where)->field($f)->limit($limit)->order($order)->select();
        foreach($lists as $k => $v){

            $result = $m->where(['realname' => $v['realname']])->count();
            $lists[$k]['cong'] = $result > 1? 1: 0;

        }
        foreach($lists as $k => $v){
            $result = $m->where(['codeid' => $v['codeid']])->count();
            $lists[$k]['cong1'] = $result > 1? 1: 0;

        }
        $this->assign('lists', $lists);
        $this->assign('page', $show);
        $this->assign('type', $id);
        $this->display('member_list');
    }
    //变更登记
    public function edit_dj(){
       //dump($_SERVER['HTTP_CLIENT_IP']);
        $m = M('new_member');
        $model = D('NewMember');
        $where = '';
        $auth=new Auth();
        $g=$auth->getGroups(session('aid'));
        $b=$g[0]['rules'];
        $a=explode(',',$b);
        $departmentArr = [];
        if(in_array("72",$a))
        {
            $departmentArr[] = 1;
        }
        if(in_array("74",$a)){
            $departmentArr[] = 2;
        }
        if(in_array("75",$a)){
            $departmentArr[] = 3;
        }
        if(in_array("76",$a)){
            $departmentArr[] = 4;
        }
        if(in_array("77",$a)){
            $departmentArr[] = 5;
        }
        if(in_array("78",$a)){
            $departmentArr[] = 6;
        }
        if(in_array("79",$a)){
            $departmentArr[] = 7;
        }
        // dump($a);die;
        //   dump($departmentArr);die;
        $departmentArr = implode(',', $departmentArr);
        $where['department_x'] = ['in',$departmentArr];


        if ($_REQUEST['member']!='') {
            $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
        }
        if(I('startime')||I('endtime')){
            $where['time_x']=array(array('gt',strtotime(I('startime').' 00:00:00')),array('lt',strtotime(I('endtime').' 23:59:59'),'and'));
        }
        //时间戳是指格林威治时间1970年01月01日00时00分00秒(北京时间1970年01月01日08时00分00秒)起至现在的总秒数。

       $where['editdecide']=1;
        list($lists, $page) = $model->getLists($where);
        $this->assign('lists', $lists);
        $this->assign('page', $page);
        $this->display();
    }
    //用户列表
    public function xiaohu_list()
    {
        $m = M('new_member');
        $where=['status' => 0];
        if ($_REQUEST['stime'] && $_REQUEST['etime'] && $_REQUEST['stime'] < $_REQUEST['etime']) {
            $stime = $_REQUEST['stime'];
            $etime = $_REQUEST['etime'];
        } else {
            $stime = $etime = null;
        }
        $auth=new Auth();
        $g=$auth->getGroups(session('aid'));
        $b=$g[0]['rules'];
        $a=explode(',',$b);
        $departmentArr = [];
        if(in_array("72",$a))
        {
            $departmentArr[] = 1;
        }
        if(in_array("74",$a)){
            $departmentArr[] = 2;
        }
        if(in_array("75",$a)){
            $departmentArr[] = 3;
        }
        if(in_array("76",$a)){
            $departmentArr[] = 4;
        }
        if(in_array("77",$a)){
            $departmentArr[] = 5;
        }
        if(in_array("78",$a)){
            $departmentArr[] = 6;
        }
        if(in_array("79",$a)){
            $departmentArr[] = 7;
        }
        $departmentArr = implode(',', $departmentArr);
        $where['department_x'] = ['in',$departmentArr];

        if (!empty($_REQUEST['keyword'])) {

            if ($_REQUEST['sx'] == '1') {

                $where .= "(groupname like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";

            } elseif ($_REQUEST['sx'] == '2') {
                $where .= "(department like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            } elseif ($_REQUEST['sx'] == '3') {
                $where .= "(agentname like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            }
            elseif ($_REQUEST['sx'] == '4') {
                $where .= "(jihuotime like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            }
            elseif ($_REQUEST['sx'] == '5') {
                $where .= "(realname like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            }
            elseif ($_REQUEST['sx'] == '6') {
                $where .= "(codeid like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            }
            else {
                $where .= "(loginname like '%" . htmlspecialchars(trim($_REQUEST['keyword'])) . "%')";
            }
        }


        $count = $m->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '末页');
        $page->setConfig('first', '首页');
        $page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $show = $page->show();
        $limit = $page->firstRow.','.$page->listRows;
        $lists = $m->where($where)->order('xh_time desc')->limit($limit)->select();
        $this->assign('lists', $lists);
        $this->assign('page', $show);
        $this->display();
    }
//综合数据统计
    public function member_zh()
    {
        $m = M('new_group');
        $data=$m->select();//小组称
        $this->assign('data',$data);
        $c = M('new_member');
        $date=$c->order('department_x')->select();//小组称
        $this->assign('date',$date);
        $tj=$m->field('xz_xksp')->where('xz_id=1')->count();//现开实盘个数
        $this->assign('tj',$tj);
        $this->display();


    }

//查看客户完整手机号
public function viewtel($id=''){
    $m = M('auth_rule');
    $field = 'id,name,title';
    $where['pid'] = 0;		//顶级ID
    $where['status'] = 1;	//显示状态
    $data = $m->field($field)->where($where)->select();

    $auth = new \Think\Auth();
    //没有权限的菜单不显示
        if(!$auth->check('NewMember/viewtel', session('aid')) && session('aid') != 1){
            echo '没有权限查发送短信';
        }else{
            $m=M('new_member');
            $id=I('id');
            $info=$m->field('tel,loginname,realname,telextend')->where('id='.$id)->find(); //查询手机号码
            $this->assign('data',$info);
            D('Common')->log('查看客户完整手机号');
            $this->display();
        }
}
    //查看客户完整手机号
    public function view($id=''){
        if(IS_POST){
            $password = I('password');
            if($password == C('PASSWORD')){
                $m = M('auth_rule');
                $field = 'id,name,title';
                $where['pid'] = 0;		//顶级ID
                $where['status'] = 1;	//显示状态
                $data = $m->field($field)->where($where)->select();
                $auth = new \Think\Auth();
                //没有权限的菜单不显示
                if(!$auth->check('Member/view', session('aid')) && session('aid') != 1){
                    echo '没有权限查看手机号';
                }else{
                    $this->member_list($id=1);
                    //R("Member/member_list/",array('id'=>1));
                }
            }else{
                echo '密码错误';

            }
        }else{
            $password = "adaddaadadadad";
            if(!session('show_phone')){
                $this->display('member_list_auth');
                die;
            }
        }
    }

//检查账号是否已注册
    public function check_password(){
        $m = M('admin');
        $where['password'] = I('password');	//账号
        $where['loginname'] =session();
        $data = $m->where($where)->find();
        if(empty($data)){
            $this->ajaxReturn(0);   //不存在
        }else{
            $this->ajaxReturn(1);	//存在
        }
    }
    //检查账号是否已注册
    public function check_loginname(){
    	$m = M('new_member');
    	$where['loginname'] = I('loginname');	//账号
    	$data = $m->field('id')->where($where)->find();
    	if(empty($data)){
    		$this->ajaxReturn(0);   //不存在
    	}else{
    		$this->ajaxReturn(1);	//存在
    	}
    }
    //经纪人离职
    public function agent_out()
    {
        $id = intval($_REQUEST['id']);
        $info = M('new_agent')->where('id=' . $id)->find();
        $this->assign('vo', $info);
        $this->display();
    }
    //离职
    public function out(){
        $Dao = M("new_out");
        $data["jobnumber"] = $_POST["jobnumber"];
        $data["agentname"] = $_POST["agentname"];
        $data["time"] = $_POST["time"];
        if(!empty($data['time'])){
            $Dao->add($data);
            $this->success('添加离职成功！');
        } else {
            $this->error('离职时间不能为空！');
        }
    }

    //添加用户
    public function member_add()
    {
        if (!empty($_POST)){

            $m = M('new_member');
            $data['loginname'] = I('loginname');
            $data['codeid'] = (I('codeid'));
            $data['time'] = time();        //创建时间
            $where['loginname'] = I('loginname');
            $result = $m->where($where)->find();

            if (!empty($result)) {
                $this->ajaxReturn(0);  //用户名重复
            }
            $_POST['time']=strtotime($_POST['time']);
            $_POST['jihuotime']=strtotime($_POST['jihuotime']);
            //添加用户
            $result['uid']  = $m->add($_POST);
            $result['group_id'] = I('group_id');	//用户组ID
            if($result['uid']){
                D('Common')->log('添加客户','添加了'.$data['loginname']);
                $m = M('auth_group_access');
                //分配用户组
                if($m->add($result)){
                    $this->ajaxReturn(1);	//分配用户组成功
                }else{
                    $this->ajaxReturn(2);	//分配用户组失败
                }
            }else{
                $this->ajaxReturn(0);  //添加用户失败
            }
        }else{
            $m = M('new_agent');
            $data = $m->field('id,agentname')->select();
           // print_r($data);die;
            $this->assign('data',$data);
            $this->display();
        }
    }
    //用户列表
    public function edit_mul($user_id){
        $user_id=$_POST['user_id'];
        $m = M('new_member');
        $str=implode(",",$user_id);
        $map['id']  = array('in',"$str");
        // page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $data = $m->order('id ASC')->page($_GET['p'].',99')->where($map)->field('id,realname,agentname,groupname,department,moniname')->select();


        $this->assign('data',$data);

        $this->display();
    }

    public function edit_mul_do($user_id){
        $m=M('new_member');
        $user_id=$_POST['user_id'];
        if($_POST['groupname_x']){
            $data['groupname_x']=trim($_POST['groupname_x']);
        }
        if($_POST['department_x']){
            $data['department_x']=trim($_POST['department_x']);
        }
        if($_POST['agentname_x']){
            $data['agentname_x']=trim($_POST['agentname_x']);
        }
        $data['time_x']=time();
        $data['editdecide']=1;
        if ($user_id==null){
            $this->error('请选择修改项！');
        }
        //判断id是数组还是一个数值
        if(is_array($user_id)){
            $where = 'id in('.implode(',',$user_id).')';
            //implode() 函数返回一个由数组元素组合成的字符串
        }else{
            $where = 'id='.$user_id;
        }
        $count=$m->where($where)->save($data); //修改表单用save函数
        //插入到变更登记表

        if ($count>0){
            D('Common')->log('批量修改客户信息','修改'.$count.'条');
            $this->success("成功修改{$count}条！",'member_list');
        }
        else {
            $this->error('批量修改失败！');
        }
    }

    //编辑
    public function member_edit()
    {
        $id = intval($_REQUEST['id']);
        if ($_POST) {
            $data = $_POST;
            $data['id']=$id;
            $data['time']=strtotime($_POST['time']);
            $data['jihuotime']=strtotime($_POST['jihuotime']);
            $data['time_x']=time();
            $list=M('new_member')->where('id='.$id)->find();
            if($list['agentname']!=$data['agentname']||$list['groupname']!=$data['groupname']||$list['department']!=$data['department']){
                $data['editdecide']=1;
            }
            if($list['agentname']!=$data['agentname']){
                $data['agentname_x']=$data['agentname'];
                unset($data['agentname']);
            }
            if($list['groupname']!=$data['groupname']){
                $data['groupname_x']=$data['groupname'];
                unset($data['groupname']);
            }
            if($list['department']!=$data['department']){
                $data['department_x']=$data['department_x'];
                unset($data['department']);
            }

            $result=M('new_member')->save($data);
            if($result){
                $name=D('new_member')->where('id='.$id)->getField('realname');
                D('Common')->log('修改客户信息','修改了'.$name.'的信息');
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        } else {
            $id = intval($_REQUEST['id']);
            $info = M('new_member')->where('id=' . $id)->find();
            $this->assign('vo', $info);

            $m = M('agent');
            $agent = $m->order('id DESC')->select();
            $this->assign('agent',$agent);
            $this->display();
        }

    }


    //销户
    public function member_del(){
        $id = intval($_REQUEST['id']);	//用户ID
        $time=I('time');

        $m = M('new_member');
        $data['status']=0;
        $data['xh_time']=strtotime($time);
        $logs=M('NewMember')->add($data);
        $result = $m->where('id='.$id)->save($data);
    	if ($result){
            $name=D('new_member')->where('id='.$id)->getField('realname');
            D('Common')->log('销户',$name);
    		$this->ajaxReturn(1);	//成功
    	}else {
    		$this->ajaxReturn(0);	//删除失败
    	}
    }

    //角色-组
    public function auth_group(){
    	$m = M('auth_group');
    	$data = $m->order('id DESC')->select();
    	$this->assign('data',$data);
    	$this->display();
    }

    //添加组
    public function group_add(){
    	if(!empty($_POST)){
    		$data['rules'] = I('rules');
    		if(empty($data['rules'])){
    			$this->error('权限不能为空');
    		}
    		$m = M('auth_group');
    		$data['title'] = I('title');
    		$data['rules'] = implode(',', $data['rules']);
    		$data['create_time'] = time();
    		if($m->add($data)){
                D('Common')->log('添加组','添加了'.$data['title']);
    			$this->success('添加成功',U('Admin/auth_group'));
    		}else{
    			$this->error('添加失败');
    		}
    	}else{
    		$m = M('auth_rule');
	    	$data = $m->field('id,name,title')->where('pid=0')->select();
	    	foreach ($data as $k=>$v){
	    		$data[$k]['sub'] = $m->field('id,name,title')->where('pid='.$v['id'])->select();
	    	}
	    	$this->assign('data',$data);	// 顶级
    		$this->display();
    	}
    }

    //编辑组
    public function group_edit(){
    	$m = M('auth_group');
    	if(!empty($_POST)){
    		$data['id'] = I('id');
    		$data['title'] = I('title');
    		$data['rules'] = implode(',', I('rules'));
    		if($m->save($data)){
                D('Common')->log('编辑组','编辑了'.$data['title']);
    			$this->success('修改成功');
    		}else{
    			$this->error('修改失败');
    		}
    	}else{
    		$where['id'] = I('id');	//组ID
    		$reuslt = $m->field('id,title,rules')->where($where)->find();
    		$reuslt['rules'] = ','.$reuslt['rules'].',';
    		$this->assign('reuslt',$reuslt);

     		$m = M('auth_rule');
    		$data = $m->field('id,title')->where('pid = 0')->select();
    		$arr = array();
    		foreach ($data as $k => $v){
    			$data[$k]['sub'] = $m->field('id,title')->where('pid ='.$v['id'])->select();
    		}
    		$this->assign('data',$data);
    		$this->display();
    	}
    }

    //删除组
    public function group_del(){
    	$where['id'] = I('id');
    	$m = M('auth_group');
    	if($m->where($where)->delete()){
    		$this->ajaxReturn(1);
    	}else{
    		$this->ajaxReturn(0);
    	}
    }

    //权限列表
    public function auth_rule(){
    	if(!empty($_POST)){
    		$m = M('auth_rule');
    		$data['name'] = I('name');
    		$data['title'] = I('title');
    		$data['pid'] = I('pid');
    		$data['create_time'] = time();
    		if($m->add($data)){
    			$this->success('添加成功','添加了'.$data['title']);	//成功
    		}else{
    			$this->success('添加失败');	//失败
    		}
    	}else{
    		$m = M('auth_rule');
    		$field = 'id,name,title,create_time,status,sort';
	    	$data = $m->field($field)->where('pid=0')->select();
	    	foreach ($data as $k=>$v){
	    		$data[$k]['sub'] = $m->field($field)->where('pid='.$v['id'])->select();
	    	}
	    	$this->assign('data',$data);	// 顶级
	    	$this->display();
    	}
    }
    //导出mysql数据到excel表格
    public function out_excel(){

        if(IS_POST){
            $m=M('new_member');
            $where = '';
            $where['status']=1;//销户用户为0
            if(I('timeselect')){
                $where[I('timeselect')]=array(array('egt',strtotime(I('startime').' 00:00:00')),array('elt',strtotime(I('endtime').' 23:59:59'),'and'));
            }
            $field='id,loginname,moniname,time,realname,sex,codeid,tel,email,address,agentname_x,groupname_x,department_x,birthday,jihuotime,jihuomoney,loginuser,remark,kaihuform';
            $data=$m->field($field)->where($where)->select();
            foreach($data as $k => $v){
                $data[$k]['time']=date('Y/m/d',$v['time']);
                $data[$k]['jihuotime']=date('Y/m/d',$v['jihuotime']);
                $type=I('type');
                if($type==0){
                   $data[$k]['tel']=tel_sub($v['tel']);
                }
            }//时间戳转化成时间

            $title=[
                0=>'序号',
                1=>'交易帐号',
                2=>'模拟帐号',
                3=>'时间',
                4=>'客户姓名',
                5=>'性别',
                6=>'身份证号码',
                7=>'电话号码',
                8=>'邮箱',
                9=>'地址',
                10=>'所属经纪人',
                11=>'小组',
                12=>'部门',
                13=>'生日',
                14=>'激活日期',
                15=>'激活资金',
                16=>'登录名',
                17=>'备注',
                18=>'开户形式',
            ];
            D('Common')->log('导出客户','导出了'.count($data).'条');
            D('new_member')->exportData( $data,$title);
        }
        if(I('user_id')!=''){
            $user_id=explode(',',I('user_id'));
            $m=M('new_member');
            $map['id']=array('in',$user_id);
            $map['status']=1;//销户用户为0
            $field='id,loginname,moniname,time,realname,sex,codeid,tel,email,address,agentname_x,groupname_x,department_x,birthday,jihuotime,jihuomoney,loginuser,remark,kaihuform';
            $data=$m->field($field)->where($map)->select();
            foreach($data as $k => $v){
                $data[$k]['time']=date('Y/m/d',$v['time']);
                $data[$k]['jihuotime']=date('Y/m/d',$v['jihuotime']);
                $type=I('type');
                if($type==0){
                    $data[$k]['tel']=tel_sub($v['tel']);
                }
            }
            $title=[
                0=>'序号',
                1=>'交易帐号',
                2=>'模拟帐号',
                3=>'时间',
                4=>'客户姓名',
                5=>'性别',
                6=>'身份证号码',
                7=>'电话号码',
                8=>'邮箱',
                9=>'地址',
                10=>'所属经纪人',
                11=>'小组',
                12=>'部门',
                13=>'生日',
                14=>'激活日期',
                15=>'激活资金',
                16=>'登录名',
                17=>'备注',
                18=>'开户形式',
            ];
            D('Common')->log('导出客户','导出了'.count($data).'条');
            D('new_member')->exportData( $data,$title);
        }
      $this->display();
    }

    // excel文件上传并导入到mysql
    public function

    add_excel_ok1() {
        //Vendor('PHPExcel.PHPExcel');
        import("Org.Util.PHPExcel");
        //设定缓存模式为经gzip压缩后存入cache（PHPExcel导入导出及大量数据导入缓存方式的修改 ）
        $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
        $cacheSettings = array();
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings);

        $objPHPExcel = \PHPExcel_IOFactory::load($_FILES["file"]["tmp_name"]);
        //内容转换为数组
        $indata = $objPHPExcel->getSheet(0)->toArray();
        $m=D('new_member');
        $errors=0;
        $success=0;
         foreach($indata as $k => $v){
             if($v[1]=='')continue;
             if($k==0||$k==1) continue;
             if($v[6]!=''){
                 if(!isMobile($v[7])){
                     $errorlist[]=$v;
                     continue;
                 }
             }
             if(!isPersonalCard($v[6])){
                 $errorlist[]=$v;
                 continue;
             }
             $where['realname']=$v[4];
             $where['codeid']=$v[6];
             $where['tel']=$v[7];
             $where['_logic'] = 'or';
             $map['_complex'] = $where;

             $map['loginname']=$v[1];

             $repeat=$m->where($map)->select();
             if($repeat){
                 $repeatlist[]=$v;
                 continue;
             }
             $data=[
                 'loginname'=>$v[1],
                 'moniname'=>$v[2],
                 'time'=>strtotime($v[3]),
                 'realname'=>$v[4],
                 'sex'=>$v[5],
                 'codeid'=>$v[6],

                 'tel'=>$v[7],
                 'email'=>$v[8],
                 'address'=>$v[9],
                 'agentname'=>$v[10],
                 'groupname'=>$v[11],
                 'department'=>$v[12],

                 'birthday'=>$v[13]?$v[13]:get_birthday($v[6]),
                 'jihuotime'=>strtotime($v[14]),
                 'jihuomoney'=>$v[15],
                 'loginuser'=>$v[16],
                 'remark'=>$v[17],
                 'kaihuform'=>$v[18],

                 'agentname_x'=>$v[10],
                 'groupname_x'=>$v[11],
                 'department_x'=>$v[12],
                 'time_x'=>'',

             ];
            // dump($data);exit;
             $result = M('new_member')->add($data);
             if($result){
                $success++;
                // $successlist[]=$v;
             }else{
                 $errors++;
                 $errorlist[]=$v;
             }
         }
        S('errorlist',$errorlist,3600);//存入缓存，时间1小时
        S('repeatlist',$repeatlist,3600);
      //  S('successlist',$successlist,3600);
        if($result){
            D('Common')->log('导入客户','导入了'.$success.'条');
            $this->success('导入成功！');

        }else{
            $this->error('导入失败！');
        }
    }

    //导出错误提示
    public function exporteError(){
        $title=[
            0=>'序号',
            1=>'交易帐号',
            2=>'模拟帐号',
            3=>'时间',
            4=>'客户姓名',
            5=>'性别',
            6=>'身份证号码',
            7=>'电话号码',
            8=>'邮箱',
            9=>'地址',
            10=>'所属经纪人',
            11=>'小组',
            12=>'部门',
            13=>'生日',
            14=>'激活日期',
            15=>'激活资金',
            16=>'登录名',
            17=>'备注',
            18=>'开户形式',
        ];
        D('new_member')->exportData(I('id')?S('errorlist'):S('repeatlist'),$title);
    }


    //激活客户列表
    public function member_jh()
    {
        $m = M('new_member');
        $where['status']=1;
        if (I('member')!='') {
            if($_REQUEST['member']=='agentname'){
                $_REQUEST['member']='agentname|agentname_x';
            }
            if(I('member')=='jihuomoney'){  //激活资金区间查询eg:20-200
                $map=explode('-',htmlspecialchars(trim(I('textsearcherkeywords'))));//把-前后分割，切割之后是数组
                $where[$_REQUEST['member']]=[['egt',$map[0]],['elt',$map[1]],'and'];
            }elseif(I('member')=='birthday'){//strpos(string,find,start)
                $birth=strpos(htmlspecialchars(trim(I('textsearcherkeywords'))),'-');
                if($birth){
                    $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
                }else{
                    $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'-'.'%');
                }
            }
            else{
                $where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
            }
        }
        //登录时间、激活时间的搜搜
        if(I('timeselect')){
            $where[I('timeselect')]=array(array('egt',strtotime(I('startime').' 00:00:00')),array('elt',strtotime(I('endtime').' 23:59:59'),'and'));
        }
        $order1='id ASC';
        $order=urldecode($_REQUEST['order']);
        $order=($order !='')?$order:$order1;
        $f='id,status';
        $auth=new Auth();
        $g=$auth->getGroups(session('aid'));
        $b=$g[0]['rules'];
        $a=explode(',',$b);

        if(in_array("49",$a))
        {
            $f.=',realname';
        }if(in_array("51",$a))
    {
        $f.=',loginname';
    }if(in_array("52",$a))
    {
        $f.=',codeid';
    }if(in_array("53",$a))
    {
        $f.=',time';
    }if(in_array("55",$a))
    {
        $f.=',tel';
    }if(in_array("56",$a))
    {
        $f.=',agentname';
    }if(in_array("57",$a))
    {
        $f.=',groupname';
    }if(in_array("58",$a))
    {
        $f.=',department';
    }if(in_array("59",$a))
    {
        $f.=',jihuotime';
    }if(in_array("60",$a))
    {
        $f.=',jihuomoney';
    }if(in_array("63",$a))
    {
        $f.=',birthday';
    }if(in_array("64",$a))
    {
        $f.=',moniname';
    }if(in_array("68",$a))
    {
        $where['jihuotime']=array(array('exp','is not null'),array('neq',''),'and');
    }
        $f.=',agentname_x';
        $f.=',groupname_x';
        $f.=',department_x';
        $f.=',remark';
        $departmentArr = [];
        if(in_array("72",$a))
        {
            $departmentArr[] = 1;
        }
        if(in_array("74",$a)){
            $departmentArr[] = 2;
        }
        if(in_array("75",$a)){
            $departmentArr[] = 3;
        }
        if(in_array("76",$a)){
            $departmentArr[] = 4;
        }
        if(in_array("77",$a)){
            $departmentArr[] = 5;
        }
        if(in_array("78",$a)){
            $departmentArr[] = 6;
        }
        if(in_array("79",$a)){
            $departmentArr[] = 7;
        }
        $departmentArr = implode(',', $departmentArr);
        $where['department_x'] = ['in',$departmentArr];
        $count = $m->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('last', '末页');
        $page->setConfig('first', '首页');
        $page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $show = $page->show();
        $limit = $page->firstRow.','.$page->listRows;
        $lists = $m->where($where)->field($f)->limit($limit)->order($order)->select();

        foreach($lists as $k => $v){

            $result = $m->where(['realname' => $v['realname']])->count();
            $lists[$k]['cong'] = $result > 1? 1: 0;

        }
        foreach($lists as $k => $v){
            $result = $m->where(['codeid' => $v['codeid']])->count();
            $lists[$k]['cong1'] = $result > 1? 1: 0;

        }
        $this->assign('lists', $lists);
        $this->assign('page', $show);
        $this->display('member_jh');
    }

    //导出mysql数据到excel表格
    public function djout_excel(){

        if(IS_POST){
            $m=M('new_member');
            $where = '';
            //  $map['jihuotime']=array(array('egt',strtotime(I('startime').' 00:00:00')),array('elt',strtotime(I('endtime').' 23:59:59'),'and'));
            if(I('timeselect')){
                $where[$_REQUEST['timeselect']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
//                $where[I('timeselect')]=array(array('egt',strtotime(I('startime').' 00:00:00')),array('elt',strtotime(I('endtime').' 23:59:59'),'and'));
            }
            $field='id,time_x,loginname,moniname,realname,codeid,agentname,agentname_x,groupname_x,department_x,remark';
            //dump($field);exit;
            $data=$m->field($field)->where($where)->select();
            foreach($data as $k => $v){
                $data[$k]['time_x']=date('Y/m/d',$v['time_x']);
                $type=I('type');
                if($type==0){
                    $data[$k]['tel']=tel_sub($v['tel']);
                }
            }//时间戳转化成时间

            $title=[
                0=>'序号',
                1=>'更改时间',
                2=>'交易帐号',
                3=>'模拟帐号',
                4=>'客户姓名',
                5=>'身份证号码',
                6=>'原经纪人',
                7=>'现经纪人',
                8=>'小组',
                9=>'部门',
                10=>'备注',
            ];
            D('Common')->log('导出客户','导出了'.count($data).'条');
            D('NewMember')->exportData( $data,$title);
        }
        if(I('user_id')!=''){
            $user_id=explode(',',I('user_id'));
            $m=M('new_member');
            $map['id']=array('in',$user_id);
            $field='id,time_x,loginname,moniname,realname,codeid,agentname,agentname_x,groupname_x,department_x,remark';
            $data=$m->field($field)->where($map)->select();
            foreach($data as $k => $v){
                $data[$k]['time_x']=date('Y/m/d',$v['time_x']);
                $type=I('type');
                if($type==0){
                    $data[$k]['tel']=tel_sub($v['tel']);
                }
            }
            $title=[
                0=>'序号',
                1=>'更改时间',
                2=>'交易帐号',
                3=>'模拟帐号',
                4=>'客户姓名',
                5=>'身份证号码',
                6=>'原经纪人',
                7=>'现经纪人',
                8=>'小组',
                9=>'部门',
                10=>'备注',
            ];
            D('Common')->log('导出客户','导出了'.count($data).'条');
            D('NewMember')->exportData( $data,$title);
        }
        $this->display();
    }
    // 发送手机短信
    public function dx(){
        $phones=I('password');// 获取号码
        $contents=I('dx');// 获取内容
        $this->sendMessage($phones, $contents."【裕道投资】");
    }
    function sendMessage($phones, $contents, $scode="", $setTime=""){

        $curlPost = "username="."金裕道贵金属"."&pwd="."bFhJHi#JKW!E"."&phones=". $phones ."&contents=".$contents."&scode=". $scode ."&setTime=" . $setTime;

        $ch = curl_init();//初始化curl
        curl_setopt($ch,CURLOPT_URL,'http://yyqd.shareagent.cn:888/sdk/service.asmx/sendMessage');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $bodytag = curl_exec($ch);//运行curl
        curl_close($ch);
        //print_r($bodytag);//输出结果

        $dom = new \DOMDocument('1.0');
        $dom ->loadXML($bodytag);
        $xml = simplexml_import_dom($dom);
        $res= $xml;
        if($res=="1"){
            echo "短信发送成功";

        }else{
            echo "短信发送失敗";

        }

    }

    /**
     * 获取可用的短信条数
     * @return [type] [description]
     */
    function get_message_number()
    {
        $curlPost = "username="."金裕道贵金属"."&pwd="."bFhJHi#JKW!E";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, 'http://yyqd.shareagent.cn:888/sdk/service.asmx/getBalance');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, '發送成功');//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $bodytag = curl_exec($ch);//运行curl
        curl_close($ch);
        // print_r($bodytag);//输出结果

        $dom = new \DOMDocument('1.0');
        $dom->loadXML($bodytag);
        $xml = simplexml_import_dom($dom);
        $res = $xml;
        return $res;
    }

}




