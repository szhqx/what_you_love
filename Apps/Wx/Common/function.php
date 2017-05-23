<?php
/**
 * Created by PhpStorm.
 * User: hrio
 * Date: 2016/4/11
 * Time: 15:04
 */

/**
 * @param string $string ԭ�Ļ�������
 * @param string $operation ����(ENCODE | DECODE), Ĭ��Ϊ DECODE
 * @param string $key ��Կ
 * @param int $expiry ������Ч��, ����ʱ����Ч�� ��λ �룬0 Ϊ������Ч
 * @return string ������ ԭ�Ļ��� ���� base64_encode ����������
 *
 * @example
 *  $a = authcode('abc', 'ENCODE', 'key');
 *  $b = authcode($a, 'DECODE', 'key');  // $b(abc)
 *  $a = authcode('abc', 'ENCODE', 'key', 3600);
 *  $b = authcode('abc', 'DECODE', 'key'); // ��һ��Сʱ�ڣ�$b(abc)������ $b Ϊ��
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    if (!$key)
        $key = 'box' . $_SERVER['HTTP_USER_AGENT'];
    // �����Կ���� ȡֵ 0-32;
    // ���������Կ���������������κι��ɣ�������ԭ�ĺ���Կ��ȫ��ͬ�����ܽ��Ҳ��ÿ�β�ͬ�������ƽ��Ѷȡ�
    // ȡֵԽ�����ı䶯����Խ�����ı仯 = 16 �� $ckey_length �η�
    // ����ֵΪ 0 ʱ���򲻲��������Կ
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * ��ȡָ��λ�õĵ����˵�
 * @param int $type ����λ��
 */
function WSTNavigation($type=0){
    $URL_HTML_SUFFIX = C('URL_HTML_SUFFIX');
    $cururl =  U(MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME);
    $cururl = str_ireplace(".".$URL_HTML_SUFFIX,'',$cururl);
    $areaId2 = (int)session('areaId2');
    $rs = F('navigation/'.$areaId2);
    if(!$rs){
        $m = M();
        //��ȡ����ʡ��
        $sql = "select parentId from __PREFIX__areas where areaId=".$areaId2;
        $areaId1Rs = $m->query($sql);
        $areaId1 = (int)$areaId1Rs[0]['parentId'];
        $sql = "select navType,navTitle,navUrl,isShow,isOpen
		  from __PREFIX__navs where isShow=1 and (areaId1=0 or areaId1=".$areaId1.") and (areaId2=0 or areaId2=".$areaId2.")
		  order by navType asc,navSort asc";
        $rs = $m->query($sql);
        F('navigation/'.$areaId2,$rs);
    }
    foreach ($rs as $key =>$v){
        $rs[$key]['url'] = $cururl;
        if(stripos($v['navUrl'],'https://')===false &&  stripos($v['navUrl'],'http://')===false){
            $rs[$key]['navUrl'] = WSTDomain()."/".$rs[$key]['navUrl'];
        }
        $rs[$key]['active'] = (stripos($rs[$key]['navUrl'],$cururl)!==false)?1:0;
        $rs[$key]['end'] = ($key==count($rs)-1)?1:0;
    }
    //����
    $data = array();
    foreach ($rs as $key =>$v){
        $data[$v['navType']][] = $v;
    }
    return $data[$type];
}

/**
 * @return array
 * ��ȡ���ﳵ����
 */
function getcart(){
    $USER = session('WST_USER');
    if(empty($USER)){
        return array();
    }
    $shopcat = array();
    $CART =  M('cart')->where('userId='.$USER['userId'])->select();
    foreach($CART as $key=>$val){
        $shopcat[$val['cartAttrs']] = json_decode($val['attrsVal'],true);
    }
    return $shopcat;
}

/**
 * ������ʽ��
 * @param unknown $number
 */
function WSTMoney($number,$lc="en_US"){
    setlocale(LC_MONETARY, $lc);
    return money_format("%=*(#10.2n", $number);
}

/**
 * ��ȡ��ҳ��Ʒ�����б�
 */
function WSTGoodsCats(){
    $cats = S("WST_CACHE_GOODS_CAT_WEB");
    if(!$cats){
        $m = M();
        $sql = "select catId,catName from __PREFIX__goods_cats WHERE parentId = 0 AND isShow =1 AND catFlag = 1 order by catSort asc";
        $rs1 = $m->query($sql);
        $cats = array();
        for ($i = 0; $i < count($rs1); $i++) {
            $cat1Id = $rs1[$i]["catId"];
            $sql = "select catId,catName from __PREFIX__goods_cats WHERE parentId = $cat1Id AND isShow =1 AND catFlag = 1 order by catSort asc";
            $rs2 = $m->query($sql);
            $cats2 = array();
            for ($j = 0; $j < count($rs2); $j++) {
                $cat2Id = $rs2[$j]["catId"];
                $sql = "select catId,catName from __PREFIX__goods_cats WHERE parentId = $cat2Id AND isShow =1 AND catFlag = 1 order by catSort asc";
                $rs3 = $m->query($sql);
                $cats3 = array();
                for ($k = 0; $k < count($rs3); $k++) {
                    $cats3[] = $rs3[$k];
                }
                $rs2[$j]["catChildren"] = $cats3;
                $cats2[] = $rs2[$j];
            }
            $rs1[$i]["catChildren"] = $cats2;
            $cats[] = $rs1[$i];
        }
        S("WST_CACHE_GOODS_CAT_WEB",$cats,31536000);
    }
    return $cats;
}

/**
 * ��ȡ���ﳵ����
 */
function WSTCartNum(){
    $shopcart = session("WST_CART")?session("WST_CART"):array();
    return count($shopcart);
}

/**
 * ����IP��ȡ����
 */
function WSTIPAddress(){

    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_ENCODING ,'utf8');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $location = curl_exec($ch);
    curl_close($ch);
    if($location){
        $location = json_decode($location);
        return array('province'=>$location->province,'city'=>$location->city,'district'=>$location->district);
    }
    return array();
}

/**
 * ��ȡ����б�
 */
function WSTAds($type){
    $ads = D('Home/Ads');
    return $ads->getAds(session("areaId2"),$type);
}


function WSTOrderScore(){
    $scoreCashRatio = $GLOBALS['CONFIG']["scoreCashRatio"];
    $scoreCash = explode(":",$scoreCashRatio);
    return (int)$scoreCash[0];
}

function WSTScoreMoney(){
    $scoreCashRatio = $GLOBALS['CONFIG']["scoreCashRatio"];
    $scoreCash = explode(":",$scoreCashRatio);
    return (int)$scoreCash[1];
}


/**
 * ��ȡ��ǰ�û�����
 */
function WSTTarget(){
    $target = array();
    $targetId = (int)session('WST_USER.userId');
    $targetType = $targetId>0?0:-1;
    if(!$targetId){
        $targetId = (int)session('WST_USER.shopId');
        $targetType = $targetId>0?1:-1;
    }
    $target["targetId"] = $targetId;
    $target["targetType"] = $targetType;
    return $target;
}

/**
 * ��ȡ��Ʒ���
 */
function returnAttr($d){
    $d = trim($d,'-');
    $temp = explode("-",$d);
    $text ='';
    if(count($temp)>1){
        $m = M();
        foreach($temp as $key=>$val){
              if($key!=0){
                  $tet = explode("_",$val);
                  $sql = "select b.attrName,b.attrContent from __PREFIX__goods_attributes as a LEFT JOIN __PREFIX__attributes as b ON a.attrId = b.attrId WHERE a.id = $tet[0] GROUP BY a.id";
                  $rs1 = $m->query($sql);
                  $attcontent = explode(",",$rs1[0]['attrContent']);
                  $attrVal = is_array($attcontent)?$attcontent[$tet[1]]:$tet[1];
                  $text .= $rs1[0]['attrName'].":".$attrVal." ";
              }
        }
    }
    return $text;
}

