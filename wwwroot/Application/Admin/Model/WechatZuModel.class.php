<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 导航模型
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class WechatZuModel extends Model {
    protected $_validate = array(
        array('title', 'require', '标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('username', 'require', '用户名不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
                array('tel', 'require', '电话不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
        array('price', 'require', '价格不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
      


    );

    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),

        array('status', '1', self::MODEL_INSERT),
    );

}
