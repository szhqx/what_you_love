<?php
namespace Wx\Action;
use Think\Controller;

class UtilsAction extends Controller {
    /*
     * * 生成二维码
     * data 要生成的内容
     * return 二进制图像
     * 调用方法 <img src="{:U('Home/Utils/getqrcode',array('data'=>'test','uid'=>3))}">
     */
    public function getqrcode() {
          ob_clean();
        include "Apps/Common/Utils/phpqrcode/qrlib.php";
        if($_GET['margin'] == "none"){
            \QRcode::png($_GET['data'], false, 'M', 8, 0);
        }else{
            \QRcode::png($_GET['data'], false, 'M', 8);
        }
    }
}