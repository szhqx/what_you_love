<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// ���PHP����
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// ��������ģʽ ���鿪���׶ο��� ����׶�ע�ͻ�����Ϊfalse
define('APP_DEBUG',true);
// ����Ӧ��Ŀ¼
define('APP_PATH','./Apps/');
/* ��չĿ¼*/
define('EXTEND_PATH', APP_PATH.'Library/');
////���밲װĿ¼
define('BIND_MODULE','Wx');
define('BIND_CONTROLLER','Wxpay');
define('BIND_ACTION', 'notify');
// ����ThinkPHP����ļ�
require './ThinkPHP/ThinkPHP.php';
