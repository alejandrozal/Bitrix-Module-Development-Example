<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;

use Bitrix\HighloadBlock as HL;
use Bitrix\Main\Entity;

CModule::IncludeModule('highloadblock');

$hlbl = 1;
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data = $entity->getDataClass();

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$postValues = $request->getPostList()->toArray();
$postValues['status'] = 'ACTIVE';
$postValues['user_name'] = 'test';
$postValues['second_name'] = 'test11';
$postValues['last_name'] = '12123test123';
$postValues['description'] = 'descr';
$postValues['title'] = 'tit';
$postValues['date_created_from'] = "17.04.2020 09:00:00";
$postValues['date_created_to'] = "17.04.2024 09:00:00";
$postValues['date_complete_from'] = "17.04.2024 09:00:00";
$postValues['date_complete_to'] = "17.04.2024 09:00:00";
$user = \Bitrix\Main\UserTable::getList(array(

    'order' => array('ID' => 'DESC'),

    'filter' => array(
        array(
            "LOGIC" => "OR",
            array(
                'NAME' => '%' . $postValues['user_name'] . '%'
            ),
            array(
                'SECOND_NAME' => '%' . $postValues['second_name'] . '%'
            ),
            array(
                'LAST_NAME' => '%' . $postValues['last_name'] . '%'
            ),
        ),
    ),
    'select' => array(
        'ID'
    ),
    'limit' => 1
));
$user = $user->fetch()[0];
$arFilter = array(
    array(
        "LOGIC" => "OR",
        array(
            "UF_STATUS" => $postValues['status'],
        ),
        array(
            "UF_USER" => $user['ID']
        ),
        array(
            "UF_DESCRIPTION" => '%' . $postValues['description'] . '%'
        ),
        array(
            "UF_TITLE" => '%' . $postValues['title'] . '%'
        ),
        array(
            ">=UF_DATE_CREATED" => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($postValues['date_created_from'])),
            "<=UF_DATE_CREATED" => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($postValues['date_created_to']))
        ),
        array(
            ">=UF_DATE_COMPLETE" => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($postValues['date_complete_from'])),
            "<=UF_DATE_COMPLETE" => \Bitrix\Main\Type\DateTime::createFromTimestamp(strtotime($postValues['date_complete_to']))
        )
    )
);

$dbData = $entity_data::getlist(array(
    'select' => array('*'),
    'order' => array('ID' => 'ASC'),
    "filter" => $arFilter,
));
$data = $dbData->fetch();

$arResult['data'] = $data;

$this->IncludeComponentTemplate();
?>