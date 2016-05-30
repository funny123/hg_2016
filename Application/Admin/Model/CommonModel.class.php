<?php
/**********************************
 * Created by PhpStorm
 * User: funny
 * Date: 2016/1/22
 * Time: 18:52
 */
 namespace Admin\Model;
 use Think\Model;
class CommonModel extends Model
{


    // 数据表名（不包含表前缀）
    protected $tableName        =   'member';


    public function getLists($map, $size = 15)
    {
        $count = $this->where($map)->count();
        $page = new \Think\Page($count, $size);
        $show = $page->show();
        $limit = $page->firstRow.','.$page->listRows;
        $lists = $this->where($map)->limit($limit)->order('id ASC')->select();
        return [$lists, $show];

    }

    public function log($name='',$data=''){
        $data1['account']=$_SESSION['account'];
        $data1['operation_details']=$name;
        $data1['login_ip']=get_client_ip();
        $data1['operation_time']=time();
        $data1['log_data']=$data;
        $logs=D('log')->add($data1);
    }
}