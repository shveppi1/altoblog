<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
class AltoSectionsList extends CBitrixComponent
{

    public function onPrepareComponentParams($arParams)
    {

        $arrFilter = $arParams["FILTER"] ?? [];

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
                $this->getSections();

                if ( !$this->arResult['ITEMS'] )
                {
                    $this->AbortResultCache();
                }


                $this->includeComponentTemplate();
            }
        } else {
            $this->getSections();
            $this->includeComponentTemplate();
        }

        if ( $this->arParams['SET_TITLE'] )
        {
            $GLOBALS['APPLICATION']->SetTitle('element.list_' . $this->arParams['IBLOCK_ID']); // надо заменить
        }

    }


    protected function getSections()
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


            $rsSection = \Bitrix\Iblock\SectionTable::getList($arFields);


            while( $arSection = $rsSection->fetch() ) {

                echo "<pre>";
                print_r($arSection);
                echo "</pre>";
                $buttons = CIBlock::GetPanelButtons(
                    $arSection["SECTION"]["IBLOCK_ID"],
                    0,
                    $arSection["SECTION"]["ID"],
                    array("SESSID"=>false, "CATALOG"=>true)
                );

                $arSection["SECTION"]["EDIT_LINK"] = $buttons["edit"]["edit_section"]["ACTION_URL"] ?? '';
                $arSection["SECTION"]["DELETE_LINK"] = $buttons["edit"]["delete_section"]["ACTION_URL"] ?? '';

                $this->arResult['ITEMS'][] = $arSection;
            }

        }

    }




}