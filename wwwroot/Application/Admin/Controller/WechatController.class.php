<?php

namespace Admin\Controller;




use Think\Page;

class WechatController extends AdminController {
    public function index(){
////        $pid = I('get.pid', 0);
////        /* 获取频道列表 */
////        $map  = array('status' => array('gt', -1), 'pid'=>$pid);
//        $list = M('WechatZu')->select();
//
//        $this->assign('list', $list);
////        $this->assign('pid', $pid);
//        $this->meta_title = '租售中心';
//        $this->display();


               $m=M('WechatZu');

            import('ORG.Util.Page');// 导入分页类
            $count= $m->count();// 查询满足要求的总记录数
            $page    = new Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数
            $page->setConfig('header','条信息');
           $show = $page->show();// 分页显示输出
            $this->assign('page',$show);// 赋值分页输出
         $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
         $this->assign('list',$list);// 赋值数据集
           $this->display();
    }
    public function add($id=0){
        if(IS_POST){
            $WechatZu = D('WechatZu');
            $data = $WechatZu->create();
            if($data){
                $id = $WechatZu->add();
                if($id){
                    $this->success('新增成功', U('index'));
                    //记录行为
                    action_log('update_channel', 'channel', $id, UID);
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($WechatZu->getError());
            }
        } else {
            $info = array();
            $info = M('WechatZu')->find($id);
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';

            $this->display('add');
        }

    }
    public function edit($id=0){
        if(IS_POST){
            $WechatZu = D('WechatZu');
            $data = $WechatZu->create();
            if($data){
                $id = $WechatZu->save();
                if($id){
                    $this->success('修改成功', U('index'));
                    //记录行为
                    action_log('update_channel', 'channel', $id, UID);
                } else {
                    $this->error('修改失败');
                }
            } else {
                $this->error($WechatZu->getError());
            }
        } else {
            $info = array();
            $info = M('WechatZu')->find($id);
            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display('add');
        }
    }
        public function del(){
            $id = array_unique((array)I('id',0));
            if ( empty($id) ) {
                $this->error('请选择要操作的数据!');
            }
            $map = array('id' => array('in', $id) );
                if(M('WechatZu')->where($map)->delete()){
                //记录行为
                action_log('update_wechat_zu', 'wechat_zu', $id, UID);
                $this->success('删除成功');
            } else {
                $this->error('删除失败！');
            }
    }
    public function active(){

        $m=M('WechatActivity');

        import('ORG.Util.Page');// 导入分页类
        $count= $m->count();// 查询满足要求的总记录数
        $page    = new Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数
        $page->setConfig('header','条信息');
        $show = $page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->display();
    }
    public function dele(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('WechatActivity')->where($map)->delete()){
            //记录行为
            action_log('update_wechat_activity', 'wechat_activity', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }

    }
    //小区保修
    public function repair(){

        $m=M('WechatRepair');

        import('ORG.Util.Page');// 导入分页类
        $count= $m->count();// 查询满足要求的总记录数
        $page    = new Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数
        $page->setConfig('header','条信息');
        $show = $page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->display();
    }
    //点击保修完成
    public function ok(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $m=M('WechatRepair');
        $m->status=1;


        if($m->where($id)->save()){
            //记录行为
            action_log('update_wechat_activity', 'wechat_activity', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    //问卷调查
    public function question(){
        $m=M('WechatRepair');

        import('ORG.Util.Page');// 导入分页类
        $count= $m->count();// 查询满足要求的总记录数
        $page    = new Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数
        $page->setConfig('header','条信息');
        $show = $page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $list  = $m->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->display();

    }
}