<?php

class Model_Response_Form extends Model_Response_Abstract
{

    protected $_EMPTY_FIELDS_ERROR = array(
        'type' => 'form',
        'code' => '30',
        'message' => 'Заполнены не все поля'
    );
    protected $_EMPTY_FIELD_ERROR = array(
        'type' => 'form',
        'code' => '31',
        'message' => 'Поле не может быть пустым'
    );
    protected $_NOTHING_CHANGE_WARNING = array(
        'type' => 'form',
        'code' => '32',
        'message' => 'Ничего не было изменено'
    );


}