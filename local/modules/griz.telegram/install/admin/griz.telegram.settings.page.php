<?php
if (is_file($_SERVER["DOCUMENT_ROOT"]."/local/modules/griz.telegram/admin/griz.telegram.settings.page.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/modules/griz.telegram/admin/griz.telegram.settings.page.php");
}
elseif (is_file($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/griz.telegram/admin/griz.telegram.settings.page.php")){
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/griz.telegram/admin/griz.telegram.settings.page.php");
}
