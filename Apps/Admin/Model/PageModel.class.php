<?php
namespace Admin\Model;
use Think\Model;

class PageModel extends Model {

    protected $insertFields =  'name,parent_id,content,keywords,description,alias';
    protected $updateFields =  'name,parent_id,content,keywords,description,alias,id';


    //验证规则
    protected $_validate = array(
        array('name','require','导航栏名不能为空',1),
        array('parent_id','require','导航栏位置必须选中一个',1),
        array('content','require','内容必须填写',1),
        array('keywords','require','关键字必须填写',1),
        array('description','require','描述必须填写',1),
        array('name', '1,30', '导航栏名最长不能超过 30 个字符！', 1, 'length', 3),
    );

    //插入之前
    protected  function _before_insert(&$data, $option){
        $data['content']=removeXSS($_POST['content']);
    }

    //删除之后
    protected function _after_delete($option){
        // $option['child_id']

    }
    
}