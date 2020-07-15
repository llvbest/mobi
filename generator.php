<?php
set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT',dirname(__FILE__).DIRECTORY_SEPARATOR );
define('IDEAL',dirname(__FILE__).DIRECTORY_SEPARATOR .'ideal'.DIRECTORY_SEPARATOR );
define('APP',dirname(__FILE__).DIRECTORY_SEPARATOR .'application'.DIRECTORY_SEPARATOR );

include IDEAL.'framework.php';

App::gi()->start();

for ($i=0;$i<=50000;$i++) {
    $itemText = file_get_contents('http://loripsum.net/api/1/');
    $itemText = preg_replace('/Lorem ipsum dolor sit amet, consectetur adipiscing elit. /uims','',$itemText);
    $model = new AlbumQuery();
    $keys = ['title','itemText','category','purchasedAt','imageName'];
    $values = [$i.'title',$itemText,mt_rand(0, 4),date("Y-m-d",time()-mt_rand(0, 3*24*60*60)),'default.png'];
        
    $status = $model->insert($keys, $values);	
}