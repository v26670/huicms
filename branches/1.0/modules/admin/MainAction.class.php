<?php

class MainAction extends Action {

    public function Index() {
        $title = "显示模板，这里使用的模板是根目";
        //echo "<pre>";print_r($title);exit;
        $this->title = $title;
        $this->display("index.html"); // 显示模板，这里使用的模板是根目
    }

    public function Test() {
        echo $this->spArgs('id')."<br>";
        echo $this->spArgs('act')."<br>";
        //die('Admin Test');
        $y = "2012";
        $m = "10";
        $time = date("t",  mktime(0,0,0,$m,1,$y));
        //echo $time;
        echo 'Success!';
    }

    public function Login() {
        echo "<pre>";print_r($_SESSION);exit;
    }
    
    public function demo(){
        $ary_get = $_GET;
        echo "<pre>";print_r($ary_get);exit;
    }

}
