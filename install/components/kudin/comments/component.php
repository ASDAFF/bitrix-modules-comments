<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!$arParams['CACHE_TIME']) {
    $arParams['CACHE_TIME'] = 3600000;
}

define('COMMENTS_IBLOCK_ID', COption::GetOptionString('comments', 'iblock'));

if(!COMMENTS_IBLOCK_ID) {
    showError('Не выбран инфоблок для комментанриев');
    return;
}

$arResult['OK'] = false;

if($_REQUEST['add']) {

    $arParams['CACHE_TIME'] = 0;

    $PROP = array();
    $PROP['ITEM'] = $arParams['ID'];

    $_REQUEST['commment'] = strip_tags($_REQUEST['commment']);

    if(!$_REQUEST['commment']) {
        $arResult['ERROR'] = 'Не введён комментарий';
    }


        if(!$arResult['ERROR']) {

            CModule::IncludeModule('iblock');
            $el = new CIBlockElement;

            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID"      => COMMENTS_IBLOCK_ID,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => TruncateText($_REQUEST['commment'], 255),
                "ACTIVE"         => "Y",
                "PREVIEW_TEXT"   => TruncateText($_REQUEST['commment'], 5000)
            );

            if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
                $arResult['OK'] = true;
            }
            else {
                $arResult['ERROR'] = $el->LAST_ERROR;
            }
        }



}

if ($this->StartResultCache()) {

    $arFilter = Array(
        "PROPERTY_ITEM" => $arParams['ID'],
        "IBLOCK_ID"=>COMMENTS_IBLOCK_ID,
        "ACTIVE"=>"Y",
    );
    $res = CIBlockElement::GetList(
        Array("DATE_CREATE"=>"DESC"),
        $arFilter,
        false,
        false,
        array('DATE_ACTIVE_FROM', 'PREVIEW_TEXT', 'CREATED_BY', 'ID', 'IBLOCK_ID', 'DATE_CREATE'));
    while($ar_fields = $res->GetNext()) {
        $ar = explode(' ', $ar_fields['DATE_CREATE']);
        $ar_fields['DATE_CREATE'] = $ar[0] . ' в ' . substr($ar[1], 0, 5);
        if($ar_fields['CREATED_BY']) {
            $rsUser = CUser::GetByID($ar_fields['CREATED_BY']);
            $ar_fields['USER'] = $rsUser->Fetch();
        } else {
            $ar_fields['USER']["LOGIN"] = 'Гость';
        }
        $arResult['COMMENTS'][] = $ar_fields;
    }
    $this->IncludeComponentTemplate();
}
