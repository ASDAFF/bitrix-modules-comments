bitrix-modules-comments
=======================

установка:

<pre>cd site/bitrix/modules/ 
git clone https://github.com/kudin/bitrix-modules-comments.git comments</pre>

<pre>$APPLICATION->IncludeComponent('kudin:comments', '', array('ID' => $ElementID, 'AJAX_MODE' => 'Y'));
</pre>