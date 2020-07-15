<?php
class Config extends Singleton{
	
	private $data = array();
    
    /** Uploads directory to web root */
    public const UPLOADS_DIR = '/uploads';
    
    /** const to db connection */
    public const DB_DRIVER = 'mysql';
    public const DB_HOST = 'localhost';
    public const DB_NAME = 'test';

    public const DB_USER = 'root';
    public const DB_PASS = 'root';
    
    public const PAGE_COUNT = 15;

    /**
     * @return string
     */
    public static function getUploadsDir()
    {
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . self::UPLOADS_DIR;

        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0775);
        }

        return $uploadsDir;
    }
    
	function associate( $group,&$array ){
		$this->data[$group] = $array;
	}
	
	function __get($name){
		return isset($this->data[$name])?$this->data[$name]:null;
	}
	
	function __set($name,$value){
		$this->data[$name] = $value;
	}
}