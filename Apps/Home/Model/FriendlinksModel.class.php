<?php
namespace Home\Model;
/**
 * ============================================================================
 * QianPokMall商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:376983512
 * ============================================================================
 * 友情连接服务类
 */
class FriendlinksModel extends BaseModel {
	/**
     * 获取友情链接
     */
	public function getFriendlinks(){
		return $this->cache('WST_CACHE_FRIENDLINK_000',31536000)->order('friendlinkSort asc')->select();
	}
}