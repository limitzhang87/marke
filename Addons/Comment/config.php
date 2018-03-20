<?php

return array(
/*   'comment_title' => array(
    'title'   => '评论标题',
    'type'    => 'text',
    'value'   => '评论列表',
    'tip'     => '可以设置文档中评论列表的标题',
    ), */
  'comment_enable' => array(
    'title' => '开启评论',
    'tip'   => '评论全局开关',
    'type'  => 'radio',
    'options' => array(
      '0' => '关闭',
      '1' => '开启',
      ),
    'value' => '1',
    ),
  'comment_verify' => array(
    'title'   => '使用验证码',
    'type'    => 'radio',
    'options' => array(
      '0' => '不使用',
      '1' => '使用'
      ),
    'value'   => '0',
    'tip'     => '提交评论时不使用验证码'
    ),
  'comment_status' => array(
    'title'   => '是否需要使用审核',
    'type'    => 'radio',
    'options' => array(
      '1' => '不使用',
      '0' => '使用'
      ),
    'value'   => '0',
    'tip'     => '提交评论时不使用审核'
    ),
  'comment_per_page' => array(
    'title'   => '每页显示评论条数',
    'type'    => 'text',
    'value'   => '25',
    'tip'     => '每页显示评论的数量，太大可能会影响性能',
    ),
  'comment_need_login' => array(
    'title'   => '登录评论',
    'type'    => 'radio',
    'options' => array(
      '0' => '否',
      '1' => '是'
      ),
    'value'   => '0',
    'tip'     => '登录用户才可以评论'
    ),
  'comment_frequency' => array(
    'title'   => '评论频率',
    'type'    => 'text',
    'value'   => '30',
    'tip'     => '两次评论的间隔多少秒'
    ),
  'comment_frequency_strict' => array(
    'title'   => '评论频率严格模式',
    'type'    => 'radio',
    'options' => array(
      '0' => '否',
      '1' => '是'
      ),
    'value'   => '1',
    'tip'     => '即使提交评论失败也会记录最后提交时间'
    ),
  'comment_template' => array(
    'title'   => '评论主题模版',
    'tip'     => '主题模版的目录名称，默认为sohu可选default',
    'type'    => 'text',
    'value'   => 'sohu'
    )
  );