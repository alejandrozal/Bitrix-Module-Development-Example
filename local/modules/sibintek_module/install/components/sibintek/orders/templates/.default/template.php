<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$grid_options = new Bitrix\Main\Grid\Options('report_list');
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'DESC'], 'vars' => ['by' => 'by', 'order' => 'order']]);
$nav_params = $grid_options->GetNavParams();

$nav = new Bitrix\Main\UI\PageNavigation('report_list');
$nav->allowAllRecords(true)
    ->setPageSize($nav_params['nPageSize'])
    ->initFromUri();

$APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
    'FILTER_ID' => 'report_list',
    'GRID_ID' => 'report_list',
    'FILTER' => [
        ['id' => 'UF_DATE_CREATED', 'name' => 'Дата создания', 'type' => 'date'],
        ['id' => 'UF_DATE_COMPLETE', 'name' => 'Дата завершения', 'type' => 'date'],
        ['id' => 'UF_STATUS', 'name' => 'Статутс', 'type' => 'list', 'items' => ['1' => 'Все', '2' => 'Активный', '3' => 'Отмененнный', '4' => 'Завершенный'], 'params' => ['multiple' => 'Y']],
        ['id' => 'UF_DESCRIPTION', 'name' => 'Описание', 'type' => 'string'],
        ['id' => 'UF_TITLE', 'name' => 'Название', 'type' => 'string'],
        ['id' => 'USER.NAME', 'name' => 'Имя', 'type' => 'string'],
    ],
    'ENABLE_LIVE_SEARCH' => true,
    'ENABLE_LABEL' => true
]);

$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => 'report_list',
    'COLUMNS' => [
        ['id' => 'UF_TITLE', 'name' => 'Название', false, 'default' => true],
        ['id' => 'UF_DATE_CREATED', 'name' => 'Дата создания', false, 'default' => true],
        ['id' => 'UF_DATE_COMPLETE', 'name' => 'Дата завершения', false, 'default' => true],
        ['id' => 'UF_STATUS', 'name' => 'Статус', false, 'default' => true],
        ['id' => 'UF_DESCRIPTION', 'name' => 'Описание', false, 'default' => true],
    ],
    'ROWS' => $arResult['data'],
    'SHOW_ROW_CHECKBOXES' => false,
    'NAV_OBJECT' => $nav,
    'AJAX_MODE' => 'Y',
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'AJAX_OPTION_JUMP'          => 'N',
    'SHOW_GRID_SETTINGS_MENU'   => false,
    'SHOW_NAVIGATION_PANEL'     => true,
    'SHOW_PAGINATION'           => true,
    'SHOW_SELECTED_COUNTER'     => false,
    'SHOW_TOTAL_COUNTER'        => true,
    'SHOW_PAGESIZE'             => true,
    'ALLOW_COLUMNS_SORT'        => false,
    'ALLOW_COLUMNS_RESIZE'      => false,
    'ALLOW_HORIZONTAL_SCROLL'   => true,
    'ALLOW_SORT'                => false,
    'ALLOW_PIN_HEADER'          => false,
    'AJAX_OPTION_HISTORY'       => 'N'
]);
?>