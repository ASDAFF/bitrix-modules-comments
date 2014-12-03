<?php
$arAllOptions = Array(
    array("iblock", "Инфоблок для хранения комментариев", "", array("text", 50)),
    array("can_edit", "Разрешить пользователям редактировать свои комментарии", "", array("checkbox")),
);
$aTabs = array(
    array("DIV" => "edit1", "TAB" => GetMessage("MAIN_TAB_SET"), "ICON" => "ib_settings", "TITLE" => GetMessage("MAIN_TAB_TITLE_SET")),
);
$tabControl = new CAdminTabControl("tabControl", $aTabs);
if ($REQUEST_METHOD == "POST" && strlen($Update . $Apply . $RestoreDefaults) > 0 && check_bitrix_sessid()) {
    if (strlen($RestoreDefaults) > 0) {
        COption::RemoveOption("comments");
    } else {
        foreach ($arAllOptions as $arOption) {
            $name = $arOption[0];
            $val = $_REQUEST[$name];
            if ($arOption[2][0] == "checkbox" && $val != "Y") {
                $val = "N";
            }
            COption::SetOptionString("comments", $name, $val, $arOption[1]);
        }
    }
    if (strlen($Update) > 0 && strlen($_REQUEST["back_url_settings"]) > 0) {
        LocalRedirect($_REQUEST["back_url_settings"]);
    } else {
        LocalRedirect($APPLICATION->GetCurPage() . "?mid=" . urlencode($mid) . "&lang=" . urlencode(LANGUAGE_ID) . "&back_url_settings=" . urlencode($_REQUEST["back_url_settings"]) . "&" . $tabControl->ActiveTabParam());
    }
}
$tabControl->Begin();
?>
<form method="post" action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($mid) ?>&amp;lang=<? echo LANGUAGE_ID ?>">
    <? $tabControl->BeginNextTab();   
    foreach ($arAllOptions as $arOption):
        $val = COption::GetOptionString("comments", $arOption[0], $arOption[2]);
        $type = $arOption[3];
        ?>
        <tr>
            <td width="40%" nowrap <? if ($type[0] == "textarea") echo 'class="adm-detail-valign-top"' ?>>
                <label for="<? echo htmlspecialcharsbx($arOption[0]) ?>"><? echo $arOption[1] ?>:</label>
            <td width="60%">
                <? if ($type[0] == "checkbox"): ?>
                    <input type="checkbox" id="<? echo htmlspecialcharsbx($arOption[0]) ?>" name="<? echo htmlspecialcharsbx($arOption[0]) ?>" value="Y"<? if ($val == "Y") echo" checked"; ?>>
                <? elseif ($type[0] == "text"): ?>
                    <input type="text" size="<? echo $type[1] ?>" maxlength="255" value="<? echo htmlspecialcharsbx($val) ?>" name="<? echo htmlspecialcharsbx($arOption[0]) ?>">
                <? elseif ($type[0] == "textarea"): ?>
                    <textarea rows="<? echo $type[1] ?>" cols="<? echo $type[2] ?>" name="<? echo htmlspecialcharsbx($arOption[0]) ?>"><? echo htmlspecialcharsbx($val) ?></textarea>
                <? endif ?>
            </td>
        </tr>
    <? endforeach ?>
    <? $tabControl->Buttons(); ?>
    <input type="submit" name="Update" value="Сохранить" class="adm-btn-save">
    <input type="submit" name="Apply" value="Применить" >
    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form> 