<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class AltoElementList extends CBitrixComponent
{

    public function onPrepareComponentParams($arParams)
    {

        $arrFilter = [];
        if ( !empty($arParams["FILTER"]) && preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER"]) )
        {
            $arrFilter = $GLOBALS[$arParams["FILTER"]] ?? [];
        }

        $result = array(
            "IBLOCK_ID" => trim($arParams["IBLOCK_ID"] ?? ''),
            'FILTER' => $arrFilter,
            'USE_CACHE' => ($arParams["USE_CACHE"] ?? '') === "Y",
            "CACHE_TIME" => isset($arParams["CACHE_TIME"]) ? $arParams["CACHE_TIME"]: 3600,
            'SORT_BY' => trim($arParams["SORT_BY"] ?? ''),
            'SORT_ORDER' => trim($arParams["SORT_ORDER"] ?? ''),
            'SET_TITLE' => ($arParams["SET_TITLE"] ?? '') === "Y",
        );
        return $result;
    }


    public function executeComponent()
    {

        if( $this->arParams['USE_CACHE'] )
        {
            if ( $this->StartResultCache() )
            {
                $this->getElements();

                if ( !$this->arResult['ITEMS'] )
                {
                    $this->AbortResultCache();
                }


                $this->includeComponentTemplate();
            }
        } else {
            $this->getElements();
            $this->includeComponentTemplate();
        }

        if ( $this->arParams['SET_TITLE'] )
        {
            $GLOBALS['APPLICATION']->SetTitle('element.list_' . $this->arParams['IBLOCK_ID']); // надо заменить
        }

    }


    protected function getElements()
    {

        if( \Bitrix\Main\Loader::includeModule('iblock' ))
        {

            $arFields = array(
                'order' => array($this->arParams['SORT_BY'] => $this->arParams['SORT_ORDER']), // сортировка
                'select' => array('*'), // выбираемые поля, без свойств. Свойства можно получать на старом ядре \CIBlockElement::getProperty
                'filter' => array_merge(array('IBLOCK_ID' => $this->arParams['IBLOCK_ID']), $this->arParams['FILTER']),
                'limit' => 50,
            );

            if ( $this->arParams['USE_CACHE'] )
            {
                $arFields['cache'] = array(
                    'ttl' => $this->arParams['CACHE_TIME'],
                    'cache_joins' => true
                );
            }


            $dbItems = \Bitrix\Iblock\ElementTable::getList($arFields);


            while( $arItem = $dbItems->fetch() ) {
                $arButtons = CIBlock::GetPanelButtons(
                    $arItem["IBLOCK_ID"],
                    $arItem["ID"],
                    0,
                    array("SECTION_BUTTONS" => false, "SESSID" => false));

                $arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"] ?? '';
                $arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"] ?? '';

                $this->arResult['ITEMS'][] = $arItem;
            }

        }

    }




}