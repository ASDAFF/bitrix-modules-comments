<?php

class comments extends CModule {

    var $MODULE_ID = __CLASS__;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS;
    var $errors = array();

    function __construct() {
        $arModuleVersion = array();
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path . "/version.php");
        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        $this->MODULE_NAME = 'Комментарии';
        $this->MODULE_DESCRIPTION = 'Актуальная версия доступна по адресу '
                . '<a href="http://github.com/kudin/bitrix-modules-comments" target="_blank">http://github.com/kudin/bitrix-modules-comments</a>';
    }

    function InstallFiles() {
        foreach(array('components', 'tools') as $dirName) {
            CopyDirFiles(
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/" . $this->MODULE_ID . "/install/" . $dirName . "/", 
                $_SERVER["DOCUMENT_ROOT"] . "/bitrix/ . $dirName . /", true, true
            );   
        } 
    }

    public function DoInstall() {
        RegisterModule($this->MODULE_ID);
        $this->InstallFiles(); 
    }

    public function DoUninstall() {
        UnRegisterModule($this->MODULE_ID);
    }

}
