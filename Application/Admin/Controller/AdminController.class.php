<?php
/*
 * @thinkphp3.2.2  客户管理   php5.3以上
 * @Created on 2015/12/18
 * @Author  funny   524656859@qq.com
 * @如果需要公共控制器，就不要继承AuthController，直接继承Controller
 */
namespace Admin\Controller;
use Common\Controller\AuthController;
use Think\Auth;

//后台管理员
class AdminController extends AuthController {
	
	//用户列表
    public function admin_list(){
    	$m = M('Admin');
    	// page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
    	$data = $m->order('id DESC')->page($_GET['p'].','.PAGE_SIZE)->select();
    	$auth = new Auth();
    	foreach ($data as $k=>$v){
    		$group = $auth->getGroups($v['id']);
    		$data[$k]['group'] = $group[0]['title'];
    	}
        //dump($data);exit;
    	$this->assign('data',$data);
    	//分页
    	$count = $m->count(id);		// 查询满足要求的总记录数
    	$page = new \Think\Page($count,PAGE_SIZE);		// 实例化分页类 传入总记录数和每页显示的记录数
    	$show = $page->show();		// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出
    	$this->display();
    }

    //检查账号是否已注册
    public function check_account(){
    	$m = M('admin');
    	$where['account'] = I('account');	//账号
    	$data = $m->field('id')->where($where)->find();
    	if(empty($data)){
    		$this->ajaxReturn(0);   //不存在
    	}else{
    		$this->ajaxReturn(1);	//存在
    	}
    }
        
    //添加用户
    public function admin_add(){
    	if(!empty($_POST)){
    		$m = M('admin');
    		$data['account'] = I('account');
    		$data['password'] = md5(I('password'));
    		$data['create_time'] = time();		//创建时间
    		$where['account'] = I('account');
    		$result = $m->where($where)->find();
    		if(!empty($result)){
    			$this->ajaxReturn(0);  //用户名重复
    		}
    		//添加用户
    		$result['uid']  = $m->add($data);
    		$result['group_id'] = I('group_id');	//用户组ID
    		if($result['uid']){
				D('Common')->log('添加用户','添加了'.$data['account']);
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
    		$m = M('auth_group');
    		$data = $m->field('id,title')->select();
    		$this->assign('data',$data);
    		$this->display();
    	}
    }

    //编辑
    public function admin_edit(){
		if(!empty($_POST)){
			//修改所属组
			$access = M('auth_group_access');
			//$data['password'] = md5(I('password'));
			if (empty($_POST['group_id'])){
				$this->error('请选择用户组');
			}
			$result = $access->where('uid='.$_POST['id'])->find();
			if(empty($result)){
				$map['uid'] = $_POST['id'];
				$map['group_id'] = $_POST['group_id'];
				$access->add($map);
			}else {
				$save['group_id'] = $_POST['group_id'];
				$access->where('uid='.$_POST['id'])->save($save);
			}
			$data['id'] = $_POST['id'];
			if(!empty($_POST['password'])){
				$data['password'] = md5($_POST['password']);
			}
			if ($_POST['status'] >= 0){
				$data['status'] = $_POST['status'];
			}
			$m = M('admin');
			$result = $m->where('id='.$data['id'])->save($data);
			if ($result === false){
				$this->error('修改失败');
			}else{
				$this->success('修改成功');
			}
		}else{
			$m = M('admin');
			$result = $m->where('id='.I('id'))->find();
			//获取当前所属组
			$auth = new Auth();
			$group = $auth->getGroups($result['id']);
			$result['title'] = $group[0]['title'];
			$result['group_id'] = $group[0]['group_id'];
			$this->assign('vo',$result);
			//获取所有组
			$m = M('auth_group');
			$group = $m->order('id DESC')->select();
			$this->assign('group',$group);
			$this->display();
		}
    }
    
    //删除用户
    public function admin_del(){
     	$id = $_POST['id'];		//用户ID
    	if($id == 1){
    		$this->ajaxReturn(0);	//不允许删除超级管理员
    	}
    	$m = M('auth_group_access');    	
    	$m->where('uid='.$id)->delete();   //删除权限表里面给的权限
    	    	
    	$m = M('admin');
    	$result = $m->where('id='.$id)->delete();
    	if ($result){
			D('Common')->log('删除用户');
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
    
    //编辑用户组
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
    		$data = $m->field('id,title,status')->where('pid = 0')->select();

    		$arr = array();
    		foreach ($data as $k => $v){
    			$data[$k]['sub'] = $m->field('id,title')->where('pid ='.$v['id'])->select();
			//	dump($data[$k]['sub']);die;
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
    			$this->success('添加成功');	//成功
    		}else{
    			$this->error('添加失败');	//失败
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



	public function manage_log(){
		//dump($_SESSION['account']);exit;
		$m = D('log');
		$where='';
		if ($_REQUEST['member1']!='') {
			$where[$_REQUEST['member1']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
		}
		$size='15';
		$count = D('log')->where($where)->count();
		$page = new \Think\Page($count, $size);
		$show = $page->show();
		$limit = $page->firstRow.','.$page->listRows;
		$list=D('log')->where($where)->limit($limit)->order('id desc')->select();
        $this->assign('list',$list);
		$this->assign('page', $show);
		$this->display();
	}

	public function delete(){
		$log=D('log');
		$condition['id']=$_GET['id'];//从页面获取id
		$del=$log->where($condition)->delete();
		if($del)
		{
			$this->success("删除成功！！！");
		}
		else
		{
			$this->error("删除失败！！！");
		}
	}


	public function agent_list()
	{
		$m = M('agent');
		$where = '';

		if ($_REQUEST['member']!='') {
			$where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
		}
		$size='15';
		$count = $m->where($where)->count();
		$page = new \Think\Page($count, $size);
		$show = $page->show();
		$limit = $page->firstRow.','.$page->listRows;
		$lists = $m->where($where)->limit($limit)->order('id')->select();
		$this->assign('lists', $lists);
		$this->assign('page', $show);
		$this->display('agent_list');
	}
	public  function agents_out(){
		$m = M('out');
		$where = '';
		if ($_REQUEST['member']!='') {
			$where[$_REQUEST['member']]=array('like','%'.htmlspecialchars(trim($_REQUEST['textsearcherkeywords'])).'%');
		}
		$size='15';
		$count = $m->where($where)->count();
		$page = new \Think\Page($count, $size);
		$show = $page->show();
		$limit = $page->firstRow.','.$page->listRows;
		$lists = $m->where($where)->limit($limit)->order('time desc')->select();
		$this->assign('lists', $lists);
		$this->assign('page', $show);
		$this->display();
	}


	public function agent_add()
	{
		if (!empty($_POST)){

			$m = M('agent');
			$data['agentname'] = I('agentname');
			$where['agentname'] = I('agentname');
			$result = $m->where($where)->find();

			//添加用户
			$result['uid']  = $m->add($_POST);
			$result['group_id'] = I('group_id');	//用户组ID
			if($result['uid']){
				D('Common')->log('添加客户','添加了'.$data['agentname']);
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
			$m = M('auth_group');
			$data = $m->field('id,title')->select();
			$this->assign('data',$data);
			$this->display();
		}
	}


	//删除用户
	public function agent_del(){
		$id = $_POST['id'];		//用户ID
		$m = M('agent');
		$name=D('agent')->where('id='.$id)->getField('agentname');
		$result = $m->where('id='.$id)->delete();
		if ($result){
			D('Common')->log('删除用户',$name);
			$this->ajaxReturn(1);	//成功
		}else {
			$this->ajaxReturn(0);	//删除失败
		}
	}

	public function agent_edit()
	{
		$id = intval($_REQUEST['id']);
		if ($_POST) {
			$data = $_POST;
			$data['id']=$id;
			$result=M('agent')->save($data);
			if($result){
				$name=D('agent')->where('id='.$id)->getField('agentname');
				D('Common')->log('修改客户信息','修改了经纪人'.$name.'的信息');
				$this->ajaxReturn(1);
			}else{
				$this->ajaxReturn(0);
			}
		} else {
			$id = intval($_REQUEST['id']);
			$info = M('agent')->where('id=' . $id)->find();
			$this->assign('vo', $info);
			$this->display();
		}

	}

	public function addagent_excel_ok1() {
		//Vendor('PHPExcel.PHPExcel');
		import("Org.Util.PHPExcel");
		//设定缓存模式为经gzip压缩后存入cache（PHPExcel导入导出及大量数据导入缓存方式的修改 ）
		$cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
		$cacheSettings = array();
		\PHPExcel_Settings::setCacheStorageMethod($cacheMethod,$cacheSettings);

		$objPHPExcel = \PHPExcel_IOFactory::load($_FILES["file"]["tmp_name"]);
		//内容转换为数组
		$indata = $objPHPExcel->getSheet(0)->toArray();
		$m=D('agent');
		$errors=0;
		$success=0;
		foreach($indata as $k => $v){
			if($v[1]=='')continue;
			if($k==0||$k==1) continue;
			$where['codeid']=$v[3];
			$where['tel']=$v[4];
			$where['_logic'] = 'or';
			$map['_complex'] = $where;

			$map['agentname']=$v[2];

			$repeat=$m->where($map)->select();
			if($repeat){
				$errorlist[]=$v;
				continue;
			}
			$data=[
				'jobnumber'=>$v[1],
				'agentname'=>$v[2],
				'codeid'=>$v[3],

				'tel'=>$v[4],
				'groupname'=>$v[5],
				'department'=>$v[6],
			];
			// dump($data);exit;
			$result = M('agent')->add($data);
			if($result){
				$success++;
				// $successlist[]=$v;
			}else{
				$errors++;
				$errorlist[]=$v;
			}
		}
		S('errorlist',$errorlist,3600);//存入缓存，时间1小时
		//  S('successlist',$successlist,3600);
		if($result){
			D('Common')->log('导入经纪人','导入了'.$success.'条');
			$this->success('导入成功！');

		}else{
			$this->error('导入失败！');
		}
	}

	//导出错误提示
	public function exporteErroragent(){
		$title=[
			0=>'序号',
			1=>'工号',
			2=>'经纪人',
			3=>'身份证号码',
			4=>'电话号码',
			5=>'小组',
			6=>'部门',
		];
		D('member')->exportData( S('errorlist'),$title);
	}
	//经纪人离职
	public function agent_out()
	{
		$id = intval($_REQUEST['id']);
		$info = M('agent')->where('id=' . $id)->find();
		$this->assign('vo', $info);
		$this->display();
	}
	//离职
	public function out(){
		$Dao = M("Out");
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
}




