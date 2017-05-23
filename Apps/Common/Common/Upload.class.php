<?php

/**
 * DOUCO TEAM
 * ============================================================================
 * * COPYRIGHT DOUCO 2013-2014.
 * ----------------------------------------------------------------------------
 * Author:DouCo
 * Id: action.class.php 2015-09-24
 */
namespace Common\Common;
use Think\Controller;
class Upload extends Controller {
	private $images_dir; 
	private $thumb_dir;
	private $upfile_type;
	private $upfile_size_max;
        private $to_file;
        public function __construct(){
		//$this->images_dir = "./Public/upload/images_dir/"; //文件上传路径 结尾加斜杠
		$this->thumb_dir = "small/"; //缩略图路径（必须在$images_dir下建立） 结尾加斜杠
		$this->upfile_type = "jpg,gif,png"; //上传的类型，默认为：jpg gif png rar zip
		$this->upfile_size_max = '1024'; //上传大小限制，单位是“KB”，默认为：1024KB
                $this->to_file = TRUE;
		
	}
	/**
	 +----------------------------------------------------------
	 * 构造函数
	 +----------------------------------------------------------
	 */
//	function Upload($images_dir,$thumb_dir)
//	{        
//		$this->images_dir = $images_dir;
//		$this->thumb_dir = $thumb_dir;
//	}
        /**
         * 上传随机码（防图片重名）
         */
        
        function random_codes($length = 5) {
            $chars = '0123456789abcdefghigklmnopqrstuvwxyz';
            $randcodes = '';
            for ($i = 0; $i < $length; $i++) {
                $randcodes .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            return $randcodes;
        }
        
        function texttype($name) {
            return substr(strrchr($name, '.'), 1);
        }
        
	/**
	 +----------------------------------------------------------
	 * 图片上传的处理函数
	 +----------------------------------------------------------
	 */
	function upload_image($imagename, $uploaddir=null) {

		$type = array("jpg", "gif", "bmp", "jpeg", "png");
                $uploaddir = empty($uploaddir) ? $this->images_dir : $uploaddir;

                if (!in_array(strtolower($this->texttype($imagename['name'])), $type)) {
                    $text = implode(",", $type);
                    showmsg( '只支持'.$text.'类型的图片');
                }

                $filename = explode(".", $imagename['name']);
                $time = date("mdHis");
                    $filename[0] = $time . $this->random_codes();
                    $name = implode(".", $filename);
                    $uploadfile = $uploaddir . $name;
                    if (move_uploaded_file($imagename['tmp_name'], $uploadfile)) {
                   
                        $photo = $name;
                    } else {
                        showmsg('上传失败');
                    }
                    return $photo;
	}

	/**
	 +----------------------------------------------------------
	 * 获取上传图片信息
	 +----------------------------------------------------------
	 */
	function get_img_info($imgurl,$photo)
	{
		$photo = $imgurl . $photo;
		$image_size = getimagesize($photo);
		$img_info["width"] = $image_size[0];
		$img_info["height"] = $image_size[1];
		$img_info["type"] = $image_size[2];
		$img_info["name"] = basename($photo);
		$img_info["ext"] = pathinfo($photo, PATHINFO_EXTENSION);
		return $img_info;
	}

	/**
	 +----------------------------------------------------------
	 * 创建图片的缩略图
	 +----------------------------------------------------------
	 */
	function make_thumb($photo,$imgurl, $width = '128', $height = '128') {
                $imgurl = empty($imgurl) ? $this->images_dir : $imgurl;
		$img_info = $this->get_img_info($imgurl,$photo);
		$photo = $imgurl . $photo; //获得图片源
		$thumb_name = substr($img_info["name"], 0, strrpos($img_info["name"], ".")) . "_thumb." . $img_info["ext"]; //缩略图名称
		if ($img_info["type"] == 1)
		{
			$img = imagecreatefromgif($photo);
		}
		elseif ($img_info["type"] == 2)
		{
			$img = imagecreatefromjpeg($photo);
		}
		elseif ($img_info["type"] == 3)
		{
			$img = imagecreatefrompng($photo);
		}
		else
		{
			$img = "";
		}
		
		if (empty ($img))
		{
			return False;
		}
		
		$width = ($width > $img_info["width"]) ? $img_info["width"] : $width;
		$height = ($height > $img_info["height"]) ? $img_info["height"] : $height;
		$thumb_width = $img_info["width"];
		$thumb_height = $img_info["height"];
		if ($thumb_width * $width > $thumb_height * $height)
		{
			$height = round($thumb_height * $width / $thumb_width);
		}
		else
		{
			$width = round($thumb_width * $height / $thumb_height);
		}
		if (function_exists("imagecreatetruecolor"))
		{
			$new_thumb = imagecreatetruecolor($width, $height);
			ImageCopyResampled($new_thumb, $img, 0, 0, 0, 0, $width, $height, $img_info["width"], $img_info["height"]);
		}
		else
		{
			$new_thumb = imagecreate($width, $height);
			ImageCopyResized($new_thumb, $img, 0, 0, 0, 0, $width, $height, $img_info["width"], $img_info["height"]);
		}
		if ($this->to_file)
		{
			if (file_exists($imgurl . $this->thumb_dir . $thumb_name))
				@ unlink($imgurl . $this->thumb_dir . $thumb_name);
			ImageJPEG($new_thumb, $imgurl . $this->thumb_dir . $thumb_name);
                          // print_r($thumb_name);exit;
			return $thumb_name;//$imgurl . $this->thumb_dir . 
		}
		else
		{
			ImageJPEG($new_thumb);
		}
		ImageDestroy($new_thumb);
		ImageDestroy($img);
               // print_r($thumb_name);exit;
		return $thumb_name;
	}

}


