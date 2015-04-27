<?php
//单例模式
class MysqlDb{
	static private $_instance;//静态私有属性用来保存类的唯一实例
	static private $_connectSource;//数据库连接资源
	private $_dbConfig=array(
		'host'=>'127.0.0.1',
		'user'=>'root',
		'password'=>'',
		'database'=>'practice'
		);//数据库配置参数
	private function __construct(){//构造函数设置为静态方法使得类无法在外部实例化

	}

	static public function getInstance(){//得到类的实例，类只能被实例化一次
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function connect(){//连接数据库函数
		if(!(self::$_connectSource)){
			self::$_connectSource=mysql_connect($this->_dbConfig['host'],$this->_dbConfig['user'],
				$this->_dbConfig['password']);

			if(!self::$_connectSource){
				die('mysql connect error'.mysql_error());
			}

			mysql_select_db($this->_dbConfig['database'],self::$_connectSource);
		}

		return self::$_connectSource;
	}

}

?>