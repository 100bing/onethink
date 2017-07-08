<?php
namespace Wechat\Controller;
use Think\Controller;
class  WechatController extends  Controller{

    public function index(){
        $this->display();
    }
    public function zushou(){
        $list = M('WechatZu')->where("neixing=1")->select();
        $index = M('WechatZu')->where("neixing=0")->select();
        $this->assign('list', $list);
        $this->assign('index', $index);
        $this->display();
    }
    public function detail($id){
        $list = M('WechatZu')->where("id=$id")->select();
        $this->assign('list', $list);

        $this->display();
    }
    public function my(){
        if ( !is_login() ) {
            $this->error( '您还没有登陆',U('Home/User/login') );
        }
        $id=session('user_outh')['uid'];
        $list = M('UcenterMember')->find($id);

        $this->assign('list', $list);


        $this->display();
    }
    public function notice(){
        $list = M('document')->select();
        $this->assign('list', $list);
        $this->display();
    }
    public function d($id){
        $list = M('DocumentArticle')->where("id=$id")->find();
        $rd = M('Document')->where("id=$id")->find();
        $this->assign('list', $list);
        $this->assign('rd', $rd);

        $this->display();
    }


}