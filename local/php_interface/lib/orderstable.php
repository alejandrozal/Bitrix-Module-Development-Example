<?php
namespace Sibintek\Orders;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\DatetimeField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\TextField;

Loc::loadMessages(__FILE__);

/**
 * Class OrdersTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_STATUS int optional
 * <li> UF_USER int optional
 * <li> UF_DESCRIPTION text optional
 * <li> UF_TITLE text optional
 * <li> UF_DATE_CREATED datetime optional
 * <li> UF_DATE_COMPLETE datetime optional
 * </ul>
 *
 * @package Bitrix\Orders
 **/

class OrdersTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'tz_orders';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => Loc::getMessage('ORDERS_ENTITY_ID_FIELD')
                ]
            ),
            new IntegerField(
                'UF_STATUS',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_STATUS_FIELD')
                ]
            ),
            new IntegerField(
                'UF_USER',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_USER_FIELD')
                ]
            ),
            new TextField(
                'UF_DESCRIPTION',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_DESCRIPTION_FIELD')
                ]
            ),
            new TextField(
                'UF_TITLE',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_TITLE_FIELD')
                ]
            ),
            new DatetimeField(
                'UF_DATE_CREATED',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_DATE_CREATED_FIELD')
                ]
            ),
            new DatetimeField(
                'UF_DATE_COMPLETE',
                [
                    'title' => Loc::getMessage('ORDERS_ENTITY_UF_DATE_COMPLETE_FIELD')
                ]
            ),
        ];
    }
}