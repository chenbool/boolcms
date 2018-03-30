<?php
namespace Home\Model;
use Think\Model;

class MenuModel extends Model {


    //获取菜单
    public function menu($type=null){

        $where['type']=empty($type) ? $type:'main';

        $res=$this->where($where)->order('sort asc')->select();
        return $this->get_tree($res,0);
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