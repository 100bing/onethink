<?php
namespace Wechat\Controller;
use Common\Api\UserApi;
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
            $this->error( '您还没有登陆',U('login') );
        }
        $id=session('user_outh')['uid'];
        $list = M('UcenterMember')->find($id);

        $this->assign('list', $list);


        $this->display();
    }
    public function notice(){
        $m=M('document');
        $list =$m->where("category_id=40 and status=1")->select();

        foreach ($list as $li){
            //显示数据的时候判段有没过期，过期了就删除数据；
            $time=time();

            if ($time-$li['deadline']>0){
                $id=$li['id'];

                $status=$m->where("id=$id")->field('status')->find();
                $status['status']=-1;
                $m->where("id=$id")->save($status);

            }
        }

        $this->assign('list', $list);
        $this->display();
    }
    public function d($id){
        $list = M('DocumentArticle')->where("id=$id")->find();
        $view=M('Document');
        $vi=$view->where("id=$id")->field('view')->find();


        $vi['view']+=1;

        $view->where("id=$id")->save($vi);
        $rd = M('Document')->where("id=$id")->find();
        $this->assign('list', $list);
        $this->assign('rd', $rd);

        $this->display();
    }
    public function message(){
        $m=M('Document');
        $list = $m->where("category_id=42 and status=1")->limit(0,1)->select();
        foreach ($list as $li){
            //显示数据的时候判段有没过期，过期了就删除数据；
            $time=time();
            if ($time-$li['deadline']>0){
                $id=$li['id'];

                $status=$m->where("id=$id")->field('status')->find();
                $status['status']=-1;
                $m->where("id=$id")->save($status);

            }
        }
        $this->assign('list', $list);
        if ( $p = I('get.p')){
            $data=M('Document')->where("category_id=42")->limit($p,1)->select();
            if ($data==null){
                $this->ajaxReturn();
             exit;


            }
            $id=$data[0]['cover_id'];
            $da = M('Picture')->where("id=$id")->find();

            $data=[
                'data'=>$data,
                'path'=>$da['path']

            ];


            $this->ajaxReturn($data);
        }


        $this->display();



    }
    //判断用户是否登陆登陆了就显示报名
    public function bao($id){
        $list = M('DocumentArticle')->where("id=$id")->find();
        $view=M('Document');
        $vi=$view->where("id=$id")->field('view')->find();


        $vi['view']+=1;

        $view->where("id=$id")->save($vi);
        $rd = M('Document')->where("id=$id")->find();
        $username=session('user_outh')['username'];
        $this->assign('list', $list);
        $this->assign('rd', $rd);


        $this->display();
    }
    //便民服务
    public function bian(){
        $m=M('Document');
        $list = $m->where("category_id=43 and status=1")->limit(0,1)->select();
        foreach ($list as $li){
            //显示数据的时候判段有没过期，过期了就删除数据；
            $time=time();

            if ($time-$li['deadline']>0){
                $id=$li['id'];

                $status=$m->where("id=$id")->field('status')->find();
                $status['status']=-1;
                $m->where("id=$id")->save($status);

            }
        }
        $this->assign('list', $list);
        if ( $p = I('get.p')){
            $data=M('Document')->where("category_id=43 and status=1")->limit($p,1)->select();
            if ($data==null){
                $this->ajaxReturn();
                exit;
            }
            $id=$data[0]['cover_id'];
            $da = M('Picture')->where("id=$id")->find();
            $data=[
                'data'=>$data,
                'path'=>$da['path']
            ];
            $this->ajaxReturn($data);
        }
        $this->display();
    }
    //商家店铺活动
    public function shop(){
      $m = M('Document');
        $list=$m->where("category_id=41 and status=1")->limit(0,1)->select();
        foreach ($list as $li){
            //显示数据的时候判段有没过期，过期了就删除数据；
            $time=time();
            if ($time-$li['deadline']>0){
                $id=$li['id'];
                $status=$m->where("id=$id")->field('status')->find();
                $status['status']=-1;
                $m->where("id=$id")->save($status);
            }
        }

        $this->assign('list', $list);
        if ( $p = I('get.p')){
            $data=M('Document')->where("category_id=41 and status=1")->limit($p,1)->select();
            if ($data==null){
                $this->ajaxReturn();
                exit;
            }
            $id=$data[0]['cover_id'];
            $da = M('Picture')->where("id=$id")->find();
            $data=[
                'data'=>$data,
                'path'=>$da['path']
            ];
            $this->ajaxReturn($data);
        }
        $this->display();
    }
    //当用户点击报名时判断有没有登陆
    public function active(){
        if ( !is_login() ) {
            $this->error( '您还没有登陆请先登录后报名',U('Home/User/login') );
        }
        $username=session('user_auth')['username'];
        if ( $id = I('get.id')){

            $data=M('WechatActivity')->where("  username='$username' and active_id=$id  ")->find();
            if ($data==null){
                $m=M('Document');
                $l=$m->where("id=$id")->find();
                $uid=session('user_auth')['uid'];
                $list = M('UcenterMember')->find($uid);//数据准备完成，可以加入数据
                $w=M('WechatActivity');
                $data['username']=$list['username'];
                $data['title']=$l['title'];
                $data['end_time']=$l['deadline'];
                $data['description']=$l['description'];
                $time=time();
                $data['create_time']=$time;
                $data['active_id']=$id;
                $data['status']=1;
                $w->add($data);
                $this->ajaxReturn();
                exit;
            }

            $this->ajaxReturn(1);
        }





    }
    //登陆界面

    public function login($username = '', $password = '', $verify = ''){
            if(IS_POST){ //登录验证
                /* 检测验证码 */
                if(!check_verify($verify)){
                    $this->error('验证码输入错误！');
                }

                /* 调用UC登录接口登录 */
                $user = new \User\Api\UserApi();
                $uid = $user->login($username, $password);
                var_dump($uid);

                if(0 < $uid){ //UC登录成功
                    /* 登录用户 */
                    $Member = D('Member');

                    if($Member->login($uid)){ //登录用户
                        //TODO:跳转到登录前页面
                        $this->success('登录成功！',U('Wechat/Wechat/my'));
                    } else {
                        $this->error($Member->getError());
                    }

                } else { //登录失败
                    switch($uid) {
                        case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                        case -2: $error = '密码错误！'; break;
                        default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                    }
                    $this->error($error);
                }

            } else { //显示登录表单
//            $this->buildHtml('login', HTML_PATH . '/news/', 'login');
                $this->display();
            }
        }
        //注册
    public function register($username = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
        if(IS_POST){ //注册用户
            /* 检测验证码 */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User = new \User\Api\UserApi();
            $uid = $User->register($username, $password, $email);
            if(0 < $uid){ //注册成功
                //TODO: 发送验证邮件
                $this->success('注册成功！',U('Wechat/Wechat/login'));
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }

        } else { //显示注册表单
            $this->display();
        }
    }
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            $this->success('退出成功！', U('Wechat/index'));
        } else {
            $this->redirect('User/login');
        }
    }

    /* 验证码，用于登录和注册 */
    public function verify(){
        $verify = new \Think\Verify();
        $verify->entry(1);
    }

    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
    }



}