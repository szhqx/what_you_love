<?php
 namespace Home\Action;
/**
 * ============================================================================
 * qpSHOP商城
 * 官网地址:http://www.qianpok.com
 * 联系QQ:874570326
 * ============================================================================
 * 文章控制器
 */
class ArticlesAction extends BaseAction{
	
	/**
	 * 帮助中心
	 */
	public function index(){
		$m = D('Wx/Articles');
    	$articleList = $m->getArticleList();
    	$obj["articleId"] = (int)I("articleId",0);
    	if(!$obj["articleId"]){
    		foreach($articleList as $key=> $articles){
    			$obj["articleId"] = $articles["articlecats"][0]["articleId"];
    			break;
    		}
    	}
    	
    	$article = $m->getArticle($obj);
    	$this->assign('articleList',$articleList);
    	$article['articleContent'] = htmlspecialchars_decode($article['articleContent']);
    	$this->assign('carticle',$article);
        $this->display("default/help_center");
        
	}
	
};
?>