<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}
/** @var array $arCurrentValues */

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
{
	return;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));


while($arRes = $rsIBlock->Fetch())
{
    $arIBlock[$arRes["ID"]] = "[" . $arRes["ID"] . "] " . $arRes["NAME"];
}


$arSort = CIBlockParameters::GetElementSortFields(
    array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
    array('KEY_LOWERCASE' => 'Y')
);

$arAscDesc = array(
    "asc" => 'По возрастанию',
    "desc" => 'По убыванию',
);


$arComponentParameters = [
	"PARAMETERS" => [
		"IBLOCK_TYPE" => [
			"PARENT" => "BASE",
			"NAME" => 'Тип информационного блока',
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		],
		"IBLOCK_ID" => [
			"PARENT" => "BASE",
			"NAME" => 'Код информационного блока',
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		],
        "FILTER" => [
            "PARENT" => "BASE",
            "NAME" => 'Название фильтра',
            "TYPE" => "STRING",
            "DEFAULT" => "arrFilter",
        ],
        "USE_CACHE" => [
            "PARENT" => "BASE",
            "NAME" => 'Использовать кеш ?',
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ],
        "CACHE_TIME" => [
            "PARENT" => "BASE",
            "NAME" => 'Время кэша (секунды)',
            "TYPE" => "STRING",
            "DEFAULT" => "36000000",
        ],
		"SORT_BY" => [
			"PARENT" => "BASE",
			"NAME" => 'Поле для первой сортировки новостей',
			"TYPE" => "LIST",
			"DEFAULT" => "ACTIVE_FROM",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
		],
		"SORT_ORDER" => [
			"PARENT" => "BASE",
			"NAME" => 'Направление для сортировки новостей',
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arAscDesc,
			"ADDITIONAL_VALUES" => "Y",
		],
		"SET_TITLE" => [
            "PARENT" => "BASE",
            "NAME" => 'Переопределять заголовок страницы',
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ]
	],
];
/*
CIBlockParameters::AddPagerSettings(
	$arComponentParameters,
	GetMessage("T_IBLOCK_DESC_PAGER_NEWS"), //$pager_title
	false, //$bDescNumbering
	false, //$bShowAllParam
	false, //$bBaseLink
	false //$bBaseLinkEnabled
);
*/
//CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
