<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("test");
?>


<?$APPLICATION->IncludeComponent(
	"alto:iblock.element.list",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"FILTER" => "arrFilter",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "content",
		"SET_TITLE" => "Y",
		"SORT_BY" => "ACTIVE_FROM",
		"SORT_ORDER" => "DESC",
		"USE_CACHE" => "Y"
	)
);?>


<?$APPLICATION->IncludeComponent(
	"alto:iblock.element",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"FILTER" => ['ID' => '8'],
		"IBLOCK_ID" => "4",
		"SET_TITLE" => "Y",
		"USE_CACHE" => "Y"
	)
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>