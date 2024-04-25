<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class AltoElement extends CBitrixComponent
{

    protected $element_id;

    public function onPrepareComponentParams($arParams)
    {
        $arrFilter = $arParams["FILTER"] ?? [];

        $result = array(
            "IBLOCK_ID" => trim($arParams["IBLOCK_ID"] ?? ''),
            'FILTER' => $arrFilter,
            'USE_CACHE' => ($arParams["USE_CACHE"] ?? '') === "Y",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"]: 3600,
            'SET_TITLE' => ($arParams["SET_TITLE"] ?? '') === "Y",
        );
        return $result;
    }


    public function executeComponent()
    {

        $this->element_id = ($this->arParams['FILTER']['ID']) ?? 0;

        if( $this->arParams['USE_CACHE'] )
        {
            if ( $this->StartResultCache() )
            {
                $this->getElement();

                if ( !isset($this->arResult['ID']) ) {
                    $this->AbortResultCache();
                }


                $this->includeComponentTemplate();
            }
        } else {
            $this->getElement();
            $this->includeComponentTemplate();
        }

        $this->addButtons();

        if ( $this->arParams['SET_TITLE'] )
        {
            $GLOBALS['APPLICATION']->SetTitle('element.list_' . $this->arParams['IBLOCK_ID']); // надо заменить
        }

    }


    protected function getElement()
    {
        if( \Bitrix\Main\Loader::includeModule('iblock') )
        {
            $dbItem = \Bitrix\Iblock\ElementTable::getById($this->element_id);
            $arItem = $dbItem->fetch();

            $this->arResult = $arItem;
        }
    }


    protected function addButtons ()
    {
        if( $this->arResult )
        {
            $arReturnUrl = array(
                "add_element" => CIBlock::GetArrayByID($this->arResult["IBLOCK_ID"], "DETAIL_PAGE_URL"),
                "delete_element" => (
                empty($arResult["SECTION_URL"]) ?
                    $this->arResult["LIST_PAGE_URL"] :
                    $this->arResult["SECTION_URL"]
                ),
            );

            $arButtons = CIBlock::GetPanelButtons(
                $this->arResult["IBLOCK_ID"],
                $this->arResult["ID"],
                $this->arResult["IBLOCK_SECTION_ID"],
                array(
                    "RETURN_URL" => $arReturnUrl,
                    "SECTION_BUTTONS" => false,
                )
            );

            $this->addIncludeAreaIcons(CIBlock::GetComponentMenu($GLOBALS['APPLICATION']->GetPublicShowMode(), $arButtons));
        }
    }




}