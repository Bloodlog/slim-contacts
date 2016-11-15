<?php
namespace App\core;

use App\core\Model;
use App\core\db\Adapter;
use \PDO;
/**
* 
*/

abstract class ModelTable extends Model
{	
	public $errors = array();
	//Название таблицы
    static public $table = '{table}';

    public function beforeSave () {
        return !count($this->errors);
    }
    /*
    * Сохранить данные
    * Проверяет есть ли значение id в аттрибутах
    * в зависимости от этого сохраняет новую или обновляет указанную запись...
    */
    public function save () {
    	$modelname = get_called_class();
        if ($this->beforeSave()) {
        	 $db = Adapter::getInstance();
            if (!$this->__get($modelname::$primary)) {
            	$sql ="";
                $db->insert($modelname::$table, $this->_data);
                $this->__set($modelname::$primary, $db->id());
            } else {
            	$sql = "";
                return $db->update($modelname::$table, $this->_data, $modelname::$primary.'='.$this->__get($modelname::$primary));
            }
        }
    }

    public static function delete($id){
    	$modelname = get_called_class();
    	$db = Adapter::getInstance();
    	$result = $db->delete($modelname::$table, $modelname::$primary . ' = ' .$id);
		return $result;
    }
    /*
    * Получить все данные из таблицы
    */
	static function models(){
		$result = array();
		$modelname = get_called_class();

		$adapter = Adapter::getInstance();
		$db = $adapter->getConnection();
		$sql = "SELECT * FROM " . $modelname::$table;
		$stmt = $db->prepare($sql);
		if ($stmt->execute()) {
			//Сколько было затронуто строк?
			if(!$stmt->rowCount()){
				$result = 0;
			}else{
				//Преобразуем результат в массив
				$result = $stmt->fetchAll();
			}   	
		} else {
			$result = 0;
		}
		return $result;
	}

	/*
    * Получить одно значение из таблицы
    */
	static function model($id){
		$result = array();
		$modelname = get_called_class();
				
		$adapter = Adapter::getInstance();
		$db = $adapter->getConnection();
		$sql = "SELECT * FROM " . $modelname::$table . " WHERE id = " . $id;
		$stmt = $db->prepare($sql);
		if ($stmt->execute()) {
			//Сколько было затронуто строк?
			if(!$stmt->rowCount()){
				$result = 0;
			}else{
				//Преобразуем результат в массив
				$result = $stmt->fetchAll();
			}
		} else {
			$result = 0;
		}
		//Кастыль
		return $result[0];
	}
}