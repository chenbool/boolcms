<?php
namespace Admin\Model;
use Think\Model;

class MenuModel extends Model {

    protected $insertFields =  'cat_name,type,status,parent_id,sort,link,page_id,cont_id';
    protected $updateFields =  'cat_name,type,status,parent_id,sort,link,page_id,cont_id,child_id';

    //验证规则
    protected $_validate = array(
        array('cat_name','require','导航栏名不能为空',1),
        array('type','require','导航栏位置必须一个',1),
        // array('link','url','无效的url地址',2),
        array('sort','number','排序只能为数值类型',1),
        array('cat_name', '1,16', '导航栏名最长不能超过 16 个字符！', 1, 'length', 3),
    );

    //自动完成
    protected $_auto = array (
        array('add_time','time',1,'function'), // 对add_time字段在新增的时候写入当前时间戳
    );

    //删除之后
    protected function _after_delete($option){
        $ids=$this->get_child_id($this->select(),$option['child_id']);    //获取子级分类的id
        M('menu')->where( array('child_id'=>array('in',$ids)) )->delete();
    }

    //获取菜单
    public function menu($type=null,$pid=0){

        if(is_null($type) ){
            $where['type']=I('get.type') ? I('get.type'):'main';
        }else{
            $where['type']=$type;
        }

        $res=$this->where($where)->order('sort asc')->select();
        return $this->get_tree($res,$pid);
    }

    //无限级分类
    public function  get_tree($arr,$pid=0,$level=0){
        static $tree=array();
        foreach($arr as $v){

            if( $v['parent_id']==$pid ){
                $v['level']=$level;
                $tree[]=$v;
                $this->get_tree($arr,$v['child_id'],$level+1);
            }

        }
        return $tree;
    }

    //获取子级分类的id
    public function get_child_id($data,$pid){
        static $children=array();
        foreach($data as $v){
            if( $v['parent_id']==$pid){
                $children[]=$v['child_id'];
                $this->get_child_id($data,$v['child_id']);
            }
        }
        return implode(',',$children);
    }

    
}