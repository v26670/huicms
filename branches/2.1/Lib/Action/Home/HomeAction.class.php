<?php
/**
 * 前台展厅控制器基类
 *
 * @package Action
 * @subpackage Home
 * @stage 1.0
 * @author Terry <admin@huicms.cn>
 * @date 2013-05-13
 */
abstract class HomeAction extends Action{
    
    /**
     * 基类初始化操作
     * @author Terry <admin@huicms.cn>
     * @date 2012-04-15
     */
    public function _initialize() {
        $this->_title();        //获取网站标题信息
        $this->_nav();
        $this->_oauth();        //获取登录授权
        $this->_links();
        $this->_announce();
        if(!C('site_status')){
            header('Content-Type:text/html; charset=utf-8');
            exit(C('site_close'));
        }
        
        import('ORG.Util.Page');
    }
    
    public function _title(){
        //SEO
        $config = D("Config")->getCfgByModule("WEBSITE");
        $page_seo = json_decode($config['WEBSITE'],true);
//        echo "<pre>";print_r($page_seo);exit;
        C($page_seo);
        $this->assign($page_seo);
    }
    
    public function _oauth(){
        $oauth = D("Oauth")->where(array('status'=>'1'))->select();
        if(!empty($oauth) && is_array($oauth)){
            foreach($oauth as $key => $val){
                $oauth[$key]['type'] = strtolower($val['code']);
                
            }
        }
//        echo "<pre>";print_r($oauth);exit;
        $this->assign("oauth",$oauth);
    }
    
    public function _empty() {
        $this->_404();
    }
    
    protected function _404($url = '') {
        if ($url) {
            redirect($url);
        } else {
            send_http_status(404);
            $this->display(TMPL_PATH . '404.html');
            exit;
        }
    }
    
    public function _nav(){
        $nav = D("Nav")->where(array('status'=>'1','`type`'=>'main'))->order('`order` desc')->select();
//        echo "<pre>";print_r($nav);exit;
        $this->assign("nav",$nav);
    }
    
    public function _links(){
        $links = D("Links")->where(array('type'=>'0','status'=>'1'))->order('`order` desc')->select();
        $this->assign("links",$links);
    }
    
    public function _announce(){
        $where = array();
        $where['status'] = '1';
        $where['starttime'] = array('lt',  date("Y-m-d H:i:s"));
        $where['endtime'] = array('gt',  date("Y-m-d H:i:s"));
        $announce = D("Announce")->where($where)->order('`order` DESC')->select();
        //echo "<pre>";print_r(D("Announce")->getLastSql());exit;
        $this->assign("announce",$announce);
    }
}
