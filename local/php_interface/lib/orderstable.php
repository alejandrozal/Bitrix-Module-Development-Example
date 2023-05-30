<?php
namespace Sibintek\Orders;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField;

Loc::loadMessages(__FILE__);

/**
 * Class OrdersTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> UF_STATUS int optional
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
        ];
    }
}