<?php
namespace Admin\Model;
use Think\Model;

class BackModel extends Model {
    protected $insertFields =  'tables,file_name,back_count,size';
    protected $updateFields =  'tables,file_name,back_count,size,id';

    //验证规则
    protected $_validate = array(
        array('tables','require','备份不能为空',1),
        array('file_name','require','备份文件名不能为空',1),
        array('file_name', '1,30', '备份文件名最长不能超过 16 个字符！', 1, 'length', 3),
    );
}