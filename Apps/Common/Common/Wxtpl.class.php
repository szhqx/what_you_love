<?php
namespace Common\Common;
use Think\Controller;
class Wxtpl extends Controller{

    private $_templatelist = array(
                "nGnnC3PXF66Xhl36Qt-izNmNUEmw5mfkkh28vawF_iI" => array(
                    "subject" => "吃友留言通知", 
                    "content" => array(
                        array("name" => "", "key" => "first"),
                        array("name" => "吃友昵称：", "key" => "keyword1"),
                        array("name" => "留言内容：", "key" => "keyword2"),
                        array("name" => "", "key" => "remark")
                    )),
                );//模板库
    private $_tempid; //微信模板id
    private $_tempData; //模板data
    private $_tempUrl;
    
    public function __construct($tempid) {
        $this->_tempid = $tempid;
    }

    
    public function getTemplist(){
        foreach($this->_templatelist as $tempid => $row){
            $data[] = array('tempid' => $tempid, 'tempname' => $row['name']);
        }
        return $data;
    }
    
    /*
     * 设置模板内容
     * @param array $content 模板内容 array("first" => array("value" => "有吃友给你留言了，快来看看吧", "color":"#999999"))
     * @return string data
     */
    public function setContent($content){
        $template = $this->_templatelist[$this->_tempid];
        foreach($template['content'] as $row){
            if(!is_array($content[$row['key']]))
                $data[$row['key']] = array("value" => "");
            else
                $data[$row['key']] = $content[$row['key']];
        }
        $this->_tempData = json_encode($data);
    }
    
    /*
     * 获取模板内容
     */
    public function getContent(){
        return $this->_tempData;
    }
    
    /*
     * 设置地址
     */
    public function setUrl($url){
        $this->_tempUrl = $url;
    }
    
    /*
     * 获取POST参数
     */
    public function getPost($openid){
        $data['touser'] = $openid;
        $data['template_id'] = $this->_tempid;
        if($this->_tempUrl)
            $data['url'] = $this->_tempUrl;
        $data['data'] = $this->_tempData;
        return json_encode($data);
    }
}
