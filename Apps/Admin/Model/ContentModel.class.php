<?php
namespace Admin\Model;
use Think\Model;

class ContentModel extends Model {

    protected $insertFields =  'name,parent_id,content,keywords,desc,img,is_top,is_recommend,is_hot';
    protected $updateFields =  'name,parent_id,content,keywords,desc,img,is_top,is_recommend,is_hot,cont_id';

    //验证规则
    protected $_validate = array(
        array('name','require','内容名称不能为空',1),
        array('parent_id','require','分类必须选中一个',1),
        array('content','require','内容必须填写',1),
        array('name', '1,50', '内容名称最长不能超过 50 个字符！', 1, 'length', 3),
    );

    //自动完成
    protected $_auto = array (
        array('add_time','time',1,'function'), // 对add_time字段在新增的时候写入当前时间戳
    );


    //插入之后
    protected function _after_insert($data, $option){
        $id=$option['child_id'];
        $data['content']=removeXSS($_POST['content']);
        M('content_desc')->add($data);
    }

    //更新之前
    protected function _before_update(&$data, $option){
        $data1['content']=removeXSS($_POST['content']);
        $id=$option['where']['cont_id'];

        M('content_desc')->where(array('cont_id'=>$id))->save($data1);

    }

    //删除之前     
    protected function _before_delete($option){
        $ids=$option['where']['cont_id'][1];
        //删除图片
        $img=explode(',', $ids);
        $this->del_img($img);


    }


    //删除之后
    protected function _after_delete($option){
        $ids=$option['cont_id'];
        //array('cont_id'=>array('in',$ids)
        //批量删除
        $where=array('cont_id'=>array( $ids[0],$ids[1] ) );
        M('content_desc')->where( $where )->delete();

    }

    
    /**
     * [content 实现分页 筛选]
     * @return [type] [description]
     */
    public function content(){
        $where=array();

        I('get.parent_id') && $where['a.parent_id']=I('get.parent_id');

        I('get.name') && $where['a.name']=array('like','%'.trim(I('get.name') ).'%'  );

        // dump($where);

        // 查询满足要求的总记录数
        $count = $this->alias('a')
                      ->join('left join __CONTENT_DESC__ as b on a.cont_id=b.cont_id')
                      ->where($where)
                      ->count();

        $Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');

        $show  = $Page->show();// 分页显示输出

        // 进行分页数据查询
        $res = $this->field('a.*,b.content,c.cat_name')
                    ->alias('a')
                    ->join('left join __CONTENT_DESC__ as b on a.cont_id=b.cont_id')
                    ->join('left join __CATEGORY__ as c on a.parent_id=c.child_id')
                    ->where($where)
                    ->order('a.sort asc')
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
        return array(
            'list' => $res,
            'page' => $show,
        );
                 
    }


    /**
     * [category_move 移动分类]
     * @param  [type] $data [修改的数据]
     * @param  [type] $parent_id [移动目标目录的id]
     * @return [type]       [description]
     */
    public function category_move($data,$parent_id){

        $temp['parent_id']=$parent_id;
        foreach ($data as $v) {
            $this->where(array('cont_id'=>$v))->save($temp);
        }
        return true;
    }


    /**
     * [del_img 删除图片]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function del_img($data){
        $config_img =C('UPLOAD');
        foreach ($data as $v) {

            $img_path=D('content')->field('img')->where(array('cont_id'=>$v))->find();

            //图片存在就删除
            is_file($config_img['rootPath'].$img_path['img']) && unlink($config_img['rootPath'].$img_path['img']);
        }
        

    }


    /**
     * [content 实现分页 筛选]
     * @return [type] [description]
     */
    public function show(){
        $where=array();

        I('get.cont_id') && $where['a.parent_id']=I('get.cont_id');

        I('get.name') && $where['a.name']=array('like','%'.trim(I('get.name') ).'%'  );

        // dump($where);

        // 查询满足要求的总记录数
        $count = $this->alias('a')
                      ->join('left join __CONTENT_DESC__ as b on a.cont_id=b.cont_id')
                      ->where($where)
                      // ->order('is_top asc ,add_time desc')
                      ->count();

        $Page  = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)

        //设置
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');    
        $Page->setConfig('next','下一页');
        $Page->setConfig('prev','上一页');

        $show  = $Page->show();// 分页显示输出

        // 进行分页数据查询
        $res = $this->field('a.*,b.content,c.cat_name')
                    ->alias('a')
                    ->join('left join __CONTENT_DESC__ as b on a.cont_id=b.cont_id')
                    ->join('left join __CATEGORY__ as c on a.parent_id=c.child_id')
                    ->where($where)
                    ->order('a.sort asc')
                    ->limit($Page->firstRow.','.$Page->listRows)
                    ->select();
        return array(
            'list' => $res,
            'page' => $show,
        );
                 
    }




}