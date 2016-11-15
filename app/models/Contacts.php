<?php

namespace App\models;

use App\core\ModelTable;
/**
* 
*/

class Contacts extends ModelTable
{
	static public $table = 'contacts';
	// Первичный ключ
	static public $primary = 'id';
	public $safe = array('id','name','surname', 'patronymic', 'age','email' , 'number', 'avatar');
	public function beforeSave() {
        if (strlen($this->name)<3) {
            $this->errors['name'] = 'У Вашего имени меньше 3-х символов. Введите полное имя.';
        }
        if (strlen($this->number)<3) {
            $this->errors['name'] = 'Мало символов у номера телефона';
        }
        return parent::beforeSave();
    }
}