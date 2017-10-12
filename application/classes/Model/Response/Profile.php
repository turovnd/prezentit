<?php

class Model_Response_Profile extends Model_Response_Abstract
{
    protected $_USER_UPDATE_SUCCESS = array (
        'type' => 'update',
        'code' => '40',
        'message' => 'Информация успешно обновлена'
    );

    protected $_USER_ID_ERROR = array (
        'type' => 'update',
        'code' => '41',
        'message' => 'Переданный ID пользователя не совпадает с ID пользователя ссесии. Попробуйте перезагрузить страницу.'
    );

    protected $_PASSWORDS_ARE_NOT_EQUAL_ERROR = array (
        'type' => 'update',
        'code' => '42',
        'message' => 'Подтверждение не совпадает с паролем'
    );

    protected $_USER_INVALID_PASSWORD_ERROR = array(
        'type' => 'update',
        'code' => '43',
        'message' => 'Не правильно введен текущий пароль'
    );

    protected $_PASSWORD_CHANGE_SUCCESS = array (
        'type' => 'update',
        'code' => '44',
        'message' => '  Пароль успешно изменен'
    );

}