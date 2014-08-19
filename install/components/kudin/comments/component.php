<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!$arParams['CACHE_TIME']) {
    $arParams['CACHE_TIME'] = 3600 * 24;
}

$requredParams = array('ID', 'ENTITY');

foreach($requredParams as $param) {
    if(!$arParams[$param]) {
        ShowError('Не передан обязательный параметр');
        return false;
    }
}

if($_REQUEST['add_comment']) {
    
    
}

if($this->StartResultCache()) {
    
    CModule::IncludeModule("iblock");

    $this->IncludeComponentTemplate();
    
}