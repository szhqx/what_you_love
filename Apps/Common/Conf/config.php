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
	    //Ĭ�ϼ���ģ��
	    'DEFAULT_MODULE'        => 'Wx',
		 /*�ļ���ͼƬ�ϴ�����*/
		 'UPLOAD_SET' => array(
			 'mimes'    => '', //�����ϴ����ļ�MiMe����
			 'maxSize'  => 5*1024*1024, //�ϴ����ļ���С���� (0-��������)
			 'exts'     => 'jpg,gif,png,jpeg', //�����ϴ����ļ���׺
			 'exts_file'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml', //�����ϴ����ļ���׺
			 'autoSub'  => true, //�Զ���Ŀ¼�����ļ�
			 'subName'  => array('date', 'Y-m'), //��Ŀ¼������ʽ��[0]-��������[1]-�������������ʹ������
			 'rootPath' => './Upload/Activity/', //�����·��
			 'savePath' => '', //����·��
			 'saveName' => array('uniqid', ''), //�ϴ��ļ���������[0]-��������[1]-�������������ʹ������
			 'saveExt'  => '', //�ļ������׺������ʹ��ԭ��׺
			 'replace'  => false, //����ͬ���Ƿ񸲸�
			 'hash'     => true, //�Ƿ�����hash����
			 'callback' => false, //����ļ��Ƿ���ڻص�������������ڷ����ļ���Ϣ����
		 ),
	);
?>
