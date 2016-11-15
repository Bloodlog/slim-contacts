<?php
namespace App\core\db;

use PDO;
/**
* 
*/
class Adapter
{

	private static $_instance;
	private $_pdo;
	private $_pdoUrl = 'mysql:host=localhost;dbname=slim-contacts;charset=utf8';
	private $_pdoUser = 'root';
	private $_pdoPassword = '';
	private $_pdoPrm = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

	/**
	* Constructor
	*/
	private function __construct() {
		$this->_pdo = new PDO($this->_pdoUrl, $this->_pdoUser, 
			$this->_pdoPassword, $this->_pdoPrm);
	}
	
	/**
	* Singleton
	*/
	private function __clone() {}
	private function __wakeup() {} 
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self;  
		}
		return self::$_instance;
	}
	
	/**
	* Get connection
	*/
	public function getConnection() {
		return $this->_pdo;
	}

	/*
	*	Получить ID последней вставленной строки
	*/ 
	public function id(){
        return $this->_pdo->lastInsertId();
    }
    
    public function query($sql){
    	$result = null;
    	$stmt = $this->_pdo->prepare($sql);
		if ($stmt->execute()) {
			//Сколько было затронуто строк?
			if(!$stmt->rowCount()){
				$result = 0;
			}else{
				$result = true;
			}   	
		} else {
			$result = 0;
		}
		return $result;
    }

 	public function insert( $table, $values ){
        $ret = $this->_arrayKeysToSet($values);
        return $this->query('insert into '.$table.' set '.$ret);
    }

    public function update( $table, $values, $where=1 ){
    	$ret = $this->_arrayKeysToSet($values);
        return $this->query('update '.$table.' set '.$ret.' where '.$where);
    }
    /*
    * Функция удаления записи по ID
    */
    public function delete( $table, $where ){
        return $this->query('delete from '.$table.' where '.$where);
    }
    /*
    * Готовим массив данных в sql запрос
    */
    private function _arrayKeysToSet($values){
        $ret='';
        if (is_array($values) or is_object($values)){
            foreach($values as $key=>$value){
                if(!empty($ret))$ret.=',';
                if (!is_numeric($key)) {
                    $ret.="`$key`='$value'";
                } else {
                    $ret.=$value;
                }
            }
        } else {
            $ret=$values;
        }
        return $ret;
    }
}