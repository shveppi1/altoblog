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
		"SET_TITLE" => [
            "PARENT" => "BASE",
            "NAME" => 'Переопределять заголовок страницы',
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ]
	],
];
