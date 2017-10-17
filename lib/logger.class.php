<?php

defined('_XIO') or die('No direct script access allowed');

class Logger 
{

    public static $PATH;

    protected static $loggers=array();
 
    protected $name;

    protected $file;

    protected $fp;
 
    public function __construct($name='info', $file=null){
        $this->name=$name;
        $this->file=$file;
 
        $this->open();
    }
 
    public function open(){
        if(self::$PATH==null){
            return ;
        }
        $this->fp=fopen($this->file==null ? self::$PATH.'/'.$this->name.'.log' : self::$PATH.'/'.$this->file,'a+');
    }
 
    public static function getLogger($name='root',$file=null){
        if(!isset(self::$loggers[$name])){
            self::$loggers[$name]=new Logger($name, $file);
        }
 
        return self::$loggers[$name];
    }
 
    public function log($message, $isPrint = true){
        if(!is_string($message)){
            $this->logPrint($message);
 
            return ;
        }
 
        $log='';
 
        $log.='['.date('D M d H:i:s Y',time()).'] ';
        if(func_num_args()>1){
            $params=func_get_args();
 
            $message=call_user_func_array('sprintf',$params);
        }
 
        $log.=$message;
        $log.="\n";
 
        $this->_write($log, $isPrint);
    }
 
    public function logPrint($obj){
        ob_start();
 
        print_r($obj);
 
        $ob=ob_get_clean();
        $this->log($ob);
    }
 
    protected function _write($string, $isPrint){
        fwrite($this->fp, $string);
 
        echo $isPrint ? $string : '';
    }
 
    public function __destruct(){
        fclose($this->fp);
    }
    
}