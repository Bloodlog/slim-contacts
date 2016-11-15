<?php
namespace App\core;

use \stdClass;
use \ArrayObject;
/**
* 
*/
abstract class Model extends ArrayObject
{
	protected $_data = null;
	public $safe     = array();

	public function __construct() {
		$_data = new stdClass();
	}

	public function __set($name, $value) {
		if ($name==='__attributes') {
			foreach ($value as $key=>$val) {
				$this->__set($key, $val);
			}
			return;
		}
		if (method_exists($this, 'set'.$name)) {
			return call_user_func(array($this,'set'.$name), $value);
		}
		if (in_array($name, $this->safe)) {
			$this->_data->$name = $value;
		}
	}

	public function __get($name) {
		if ($name==='__attributes') {
			return $this->_data;
		}
		if (method_exists($this, 'get'.$name)) {
			return call_user_func(array($this,'get'.$name));
		}
		return property_exists($this->_data, $name) ? $this->_data->$name : null;
	}
}