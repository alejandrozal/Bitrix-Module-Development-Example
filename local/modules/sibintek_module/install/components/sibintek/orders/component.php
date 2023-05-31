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

$list = $entity_data::getlist(
    array(
        'select' => array(
            'ID',
            'USER_NAME' => 'USER.NAME',
            'USER_SECOND_NAME' => 'USER.SECOND_NAME',
            'USER_LAST_NAME' => 'USER.LAST_NAME',
            'UF_TITLE',
            'UF_STATUS',
            'UF_DESCRIPTION',
            'UF_DATE_CREATED',
            'UF_DATE_COMPLETE'
        ),
        'group' => array('ID'),
        'order' => array('ID' => 'ASC'),
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
$list = $list->fetchAll();
$result = [];
foreach ($list as $item) {
    $tmpResult = [];
    foreach ($item as $key => $value) {
        if ($key == 'UF_DATE_CREATED') {
            $tmpResult['data']['UF_DATE_CREATED'] = $value->toString();
        }
        if ($key == 'UF_DATE_COMPLETE') {
            $tmpResult['data']['UF_DATE_COMPLETE'] = $value->toString();
        }
        if ($key == 'UF_TITLE') {
            $tmpResult['data']['UF_TITLE'] = $value;
        }
        if ($key == 'UF_STATUS') {
            $tmpResult['data']['UF_STATUS'] = $value;
        }
        if ($key == 'UF_DESCRIPTION') {
            $tmpResult['data']['UF_DESCRIPTION'] = $value;
        }
        if ($key == 'ID') {
            $tmpResult['data']['ID'] = $value;
        }
        if ($key == 'USER_NAME') {
            $tmpResult['data']['USER_NAME'] = $value;
        }
        if ($key == 'USER_SECOND_NAME') {
            $tmpResult['data']['USER_SECOND_NAME'] = $value;
        }
        if ($key == 'USER_LAST_NAME') {
            $tmpResult['data']['USER_LAST_NAME'] = $value;
        }
    }
    $result[] = $tmpResult;
}
$arResult['data'] = $result;
$this->IncludeComponentTemplate();
?>