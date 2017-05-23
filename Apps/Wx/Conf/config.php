<?php
return array(
	//'配置项'=>'配置值'
    /* 模板路径相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__IMG__'    => __ROOT__ . '/static/images', //图片路径+module_name
        '__CSS__'    => __ROOT__ . '/static/css',  //CSS路径+module_name
        '__JS__'     => __ROOT__ . '/static/js',//JS路径+module_name
        '__WX__' => __ROOT__.'/static/wx/',
    ),
    'URL_CASE_INSENSITIVE' => true,

);