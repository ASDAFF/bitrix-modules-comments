<? 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { 
    die();
}

if (!$arParams['CACHE_TIME']) {
    $arParams['CACHE_TIME'] = 3600000;
}

define('COMMENTS_IBLOCK_ID', COption::GetOptionString('comments', 'iblock'));
 
if (!COMMENTS_IBLOCK_ID) {
    showError('Не выбран инфоблок для комментанриев');
    return;
}

function reCalculateCommentsCnt($itemID) {
    
      $res = CIBlockElement::GetList(
            array("DATE_CREATE" => "DESC"), 
            array("PROPERTY_ITEM" => $itemID,
                  "IBLOCK_ID" => COption::GetOptionString('comments', 'iblock'),
                  "ACTIVE" => "Y"),
            false,
            false,
            array('ID', 'IBLOCK_ID'));
      
      while ($ar_fields = $res->GetNext()) {
          $n++; // ай пока что через пень-колоду 
      }
      
      global $CACHE_MANAGER;
      $CACHE_MANAGER->ClearByTag('iblock_id_9');  // абы што  
      CIBlockElement::SetPropertyValuesEx($itemID, false, array('COMMNETS_CNT' => $n)); 
}

$arResult['OK'] = false;

if ($_REQUEST['add']) { 
    $arParams['CACHE_TIME'] = 0; 
    $PROP = array();
    $PROP['ITEM'] = $arParams['ID']; 
    $_REQUEST['commment'] = strip_tags($_REQUEST['commment']); 
    if (!$_REQUEST['commment']) {
        $arResult['ERROR'] = 'Не введён комментарий';
    }
 
    if (!$arResult['ERROR']) { 
        CModule::IncludeModule('iblock');
        $el = new CIBlockElement; 
        $arLoadProductArray = Array(
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => COMMENTS_IBLOCK_ID,
            "DATE_ACTIVE_FROM" => ConvertTimeStamp(false, 'FULL'),
            "PROPERTY_VALUES" => $PROP,
            "NAME" => TruncateText($_REQUEST['commment'], 255),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => TruncateText($_REQUEST['commment'], 5000)
        ); 
        if ($PRODUCT_ID = $el->Add($arLoadProductArray)) {
            $arResult['OK'] = true;
            reCalculateCommentsCnt($arParams['ID']);
        } else {
            $arResult['ERROR'] = $el->LAST_ERROR;
        }
    }
}

$arResult['USER_ID'] = $USER->GetID();

$cache_id = serialize($arParams); 
$cache_dir = '/comments';
$obCache = new CPHPCache;
if ($obCache->InitCache($arParams['CACHE_TIME'], $cache_id, $cache_dir)) {
    
    $arResult = $obCache->GetVars();
    
} elseif ($obCache->StartDataCache()) { 
    
    global $CACHE_MANAGER;
    $CACHE_MANAGER->StartTagCache($cache_dir);
    $CACHE_MANAGER->RegisterTag("iblock_id_" . COMMENTS_IBLOCK_ID); 
    $CACHE_MANAGER->EndTagCache();

    CModule::IncludeModule('iblock');
     
    $res = CIBlockElement::GetList(
        array("DATE_ACTIVE_FROM" => "DESC"), 
        array("PROPERTY_ITEM" => $arParams['ID'], 
              "IBLOCK_ID" => COMMENTS_IBLOCK_ID, 
              "ACTIVE" => "Y"), 
        false,
        false,  
        array('DATE_ACTIVE_FROM', 'PREVIEW_TEXT', 'CREATED_BY', 'ID', 'IBLOCK_ID', 'DATE_CREATE'));
    
    while ($ar_fields = $res->GetNext()) {  
        $arResult['COMMENTS'][] = $ar_fields;
    } 
      
    $obCache->EndDataCache($arResult); 
}

 
$this->IncludeComponentTemplate();

