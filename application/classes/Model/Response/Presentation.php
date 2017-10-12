<?php

class Model_Response_Presentation extends Model_Response_Abstract
{
    protected $_PRESENTATION_CREATE_SUCCESS = array (
        'type' => 'create',
        'code' => '50',
        'message' => 'Презентация успешно создана'
    );

    protected $_EMPTY_PRESENTATION_NAME_ERROR = array (
        'type' => 'create',
        'code' => '51',
        'message' => 'Не '
    );

    protected $_PRESENTATION_DELETE_SUCCESS = array (
        'type' => 'delete',
        'code' => '52',
        'message' => 'Презентация успешно удалена'
    );

    protected $_PRESENTATION_ID_REQUIRE_ERROR = array (
        'type' => 'create_slides',
        'code' => '53',
        'message' => 'Не передано ID презентации. Перезагрузите страницу и попробуйте снова.'
    );

    protected $_PRESENTATION_DOES_NOT_EXIST_ERROR = array (
        'type' => 'create_slides',
        'code' => '53',
        'message' => 'Презентация не существует'
    );

    protected $_PRESENTATION_UPDATE_SUCCESS = array (
        'type' => 'update',
        'code' => '54',
        'message' => 'Информация успешно обновлена'
    );

}