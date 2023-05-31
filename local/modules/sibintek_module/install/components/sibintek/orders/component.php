<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;

use Bitrix\HighloadBlock as HL;
use Bitrix\Main\Entity;
use \Bitrix\Main\UserTable;

CModule::IncludeModule('highloadblock');

$hlbl = 1;
$hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data = $entity->getDataClass();

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$postValues = $request->getPostList()->toArray();
$postValues['status'] = 'ACTIVE';
$postValues['user_id'] = 2;
$postValues['user_name'] = 'test';
$postValues['second_name'] = 'test11';
$postValues['last_name'] = '12123test123';
$postValues['description'] = 'descr';
$postValues['title'] = 'tit';
$postValues['date_created_from'] = "17.04.2020 09:00:00";
$postValues['date_created_to'] = "17.04.2024 09:00:00";
$postValues['date_complete_from'] = "17.04.2024 09:00:00";
$postValues['date_complete_to'] = "17.04.2024 09:00:00";

$pageSize = 1;
$page = 1;

$list = $entity_data::getlist(
    array(
        'select' => array('*'
        ),
        'filter' => array(
            array(
                "LOGIC" => "OR",
                array(
                    "UF_STATUS" => $postValues['status'],
                ),
                array(
                    "UF_USER" => $postValues['user_id'],
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
        ),
        'group' => array('ID'),
        'order' => array('ID' => 'ASC'),
//        'limit' => $pageSize,
//        'offset' => $page * $pageSize,
        'count_total' => true,
        'runtime' => array(
            new Entity\ReferenceField(
                'USER',
                UserTable::getEntity(),
                array(
                    '=ref.ID' => 'this.UF_USER',
                ),
                array('join_type' => 'left')
            )
        )
    )
);
$list = $list->fetch();
$result = [];
foreach ($list as $key => $value) {
    if ($key == 'UF_DATE_CREATED') {
        $result['data']['UF_DATE_CREATED'] = $value->toString();
    }
    if ($key == 'UF_DATE_COMPLETE') {
        $result['data']['UF_DATE_COMPLETE'] = $value->toString();
    }
    if ($key == 'UF_TITLE') {
        $result['data']['UF_TITLE'] = $value;
    }
    if ($key == 'UF_STATUS') {
        $result['data']['UF_STATUS'] = $value;
    }
    if ($key == 'UF_DESCRIPTION') {
        $result['data']['UF_DESCRIPTION'] = $value;
    }
}

$arResult['data'] = [$result];
$this->IncludeComponentTemplate();
?>