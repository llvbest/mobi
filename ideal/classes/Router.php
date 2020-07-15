<?php
class Router extends Singleton{
    
	public $action = 'index';
	public $controller = 'Index';
    
	function parse(){
	    //one controller - одностраничное приложение!
		//if( isset($_REQUEST['controller']))
			//$this->controller = $_REQUEST['controller'];
		if( isset($_REQUEST['action']) )
			$this->action = $_REQUEST['action'];
	}
}