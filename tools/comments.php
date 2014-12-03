<?php

$id = intval($_REQUEST['id']);
    
$action = $_REQUEST['action'];

if(!in_array($action, array('edit', 'delete')) || !$id) {
    die();
} 

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
    

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


CModule::IncludeModule('iblock');    
    
$res = CIBlockElement::GetByID($id);
if($comment = $res->GetNext()) {
    
    if($comment['IBLOCK_ID'] != COption::GetOptionString('comments', 'iblock')) {
        die('err1');
    }
    
    if($comment['CREATED_BY'] != $USER->GetID()) {
        die('err2');
    }
    
    $_REQUEST['text'] = trim($_REQUEST['text']); 
    
    switch ($action) {
        case 'edit': 
            $el = new CIBlockElement();
            $el->Update($id, array("PREVIEW_TEXT" => $_REQUEST['text']));
            break;
        case 'delete':
             CIBlockElement::Delete($id);
            
            
              $itemID = intval($_REQUEST['item']);
            reCalculateCommentsCnt($itemID);
           
            break;  
    }
      
    
}

