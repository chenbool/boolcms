<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

    function _initialize(){

    	$system_config=C('CONFIG');

        $menu_list=D('Admin/Menu')->menu();
        $top_list=D('Admin/Menu')->menu('top');
        $bottom_list=D('Admin/Menu')->menu('bottom');

    	$this->assign(array(
    		'system_config'	=>	$system_config,
    		'main_list'   	=>	$menu_list,
    		'top_list'	    =>	$top_list,
    		'bottom_list'	=>	$bottom_list,
    	));

        // dump($system_config);
    }


}