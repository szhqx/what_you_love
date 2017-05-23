<?php
 return array(
	    'URL_CASE_INSENSITIVE'  =>  true,
	    'VAR_PAGE'=>'p',
	    'PAGE_SIZE'=>15,
		'DB_TYPE'=>'mysql',
	    'DB_HOST'=>'127.0.0.1',//120.25.200.1
	    'DB_NAME'=>'xihuansha',
	    'DB_USER'=>'root',//zbc
	    'DB_PWD'=>'513366', //zbc5133
	    'DB_PREFIX'=>'wj_',
	    'DEFAULT_C_LAYER' =>  'Action',
	    'DEFAULT_CITY' => '350000',
	    'DATA_CACHE_SUBDIR'=>false,
        'DATA_PATH_LEVEL'=>2,
	    'URL_MODEL' => 2,
	    'SESSION_PREFIX' => 'QIANPOKMALL',
        'COOKIE_PREFIX'  => 'QIANPOKMALL',
		'LOAD_EXT_CONFIG' => 'wst_config',
	    //默认加载模块
	    'DEFAULT_MODULE'        => 'Wx',
		 /*文件和图片上传配置*/
		 'UPLOAD_SET' => array(
			 'mimes'    => '', //允许上传的文件MiMe类型
			 'maxSize'  => 5*1024*1024, //上传的文件大小限制 (0-不做限制)
			 'exts'     => 'jpg,gif,png,jpeg', //允许上传的文件后缀
			 'exts_file'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //允许上传的文件后缀
			 'autoSub'  => true, //自动子目录保存文件
			 'subName'  => array('date', 'Y-m'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
			 'rootPath' => './Upload/Activity/', //保存根路径
			 'savePath' => '', //保存路径
			 'saveName' => array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
			 'saveExt'  => '', //文件保存后缀，空则使用原后缀
			 'replace'  => false, //存在同名是否覆盖
			 'hash'     => true, //是否生成hash编码
			 'callback' => false, //检测文件是否存在回调函数，如果存在返回文件信息数组
		 ),
	);
?>
