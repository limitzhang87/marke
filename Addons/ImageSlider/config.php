<?php
return array(
    'status'=>array(
        'title'=>'是否开启:',
        'type'=>'radio',
        'options'=>array(
            '1'=>'开启',
            '0'=>'关闭',
        ),
        'value'=>'0',
    ),
    'type'=>array(
        'title'=>'插件选择:',
        'type'=>'select',
        'options'=>array(
            'flexslider'=>'FlexSlider'
        ),
        'value'=>0,
    ),
    'position'=>array(
        'title' => '推荐位序号（<a href="/admin.php/Config/group/id/2" target="_blank">填写网站设置文档推荐位的序号</a>）',
        'type'  => 'text',
        'value' => '1'
    ),
    'category'=>array(
        'title' => '分类ID（不填写表示所有分类）',
        'type'  => 'text',
        'value' => ''
    ),
    'images'=>array(
        'title' => '轮播图片（双击可移除）',
        'type'  => 'picture_union',
        'value' => ''
    ),
    'url'=>array(
        'title'=>'图片链接（一行对应一个图片）',
        'type'=>'textarea',
        'value'=>''
    ),
    'second'=>array(
        'title'=>'轮播间隔时间（单位 毫秒）:',
        'type'=>'text',
        'value'=>'3000', 
    ),
    'direction'=>array(
        'title'=>'图片滚动方向:',
        'type'=>'radio',
        'options'=>array(
            'horizontal'=>'横向滚动',
            'vertical'=>'纵向滚动',
        ),
        'value'=>'horizontal',
    ),
    'imgWidth'=>array(
        'title'=>'容器宽度（单位　像素）',
        'type'=>'text',
        'value'=>'960'
    ),
    'imgHeight'=>array(
        'title'=>'容器高度（单位　像素）',
        'type'=>'text',
        'value'=>'200'
    ),
    
);
                    