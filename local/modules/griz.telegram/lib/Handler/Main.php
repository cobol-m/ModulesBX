<?php
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2022
 * ==================================================
 * Bit.Umc - Bitrix integration - Main.php
 * 09.12.2022 00:35
 * ==================================================
 */
namespace Griz\Telegram\Handler;

use Griz\Telegram\Internals\Control\ServiceManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Class Main
 * @package Griz\Telegram\Handler
 */
class Main
{
    /**
     * @param $arGlobalMenu
     * @param $arModuleMenu
     */
    public static function onBuildGlobalMenu(&$arGlobalMenu, &$arModuleMenu): void
    {
        if (!defined('ANZ_APPOINTMENT_MENU_INCLUDED'))
        {
            define('ANZ_APPOINTMENT_MENU_INCLUDED', true);

            $moduleID        = ServiceManager::getModuleId();
            $vendorName      = explode('.', $moduleID)[0];
            $moduleNameShort = explode('.', $moduleID)[1];

            $GLOBALS['APPLICATION']->SetAdditionalCss("/bitrix/css/".$vendorName."/".$moduleNameShort. "/menu.css");

            if ($GLOBALS['APPLICATION']->GetGroupRight($moduleID) >= 'R')
            {
                $arMenu = array(
                    'menu_id' => 'global_menu_griz_telegram',
                    'text' => Loc::getMessage('GRIZ_TELEGRAM_MENU_MAIN_TITLE'),
                    'title' => Loc::getMessage('GRIZ_TELEGRAM_MENU_MAIN_TITLE'),
                    'sort' => 1000,
                    'items_id' => 'global_menu_griz_telegram',
                    'icon' => 'ui-icon ui-icon-service-site-b24 ui-icon-sm griz_telegram_main_icon',
                    'items' => array(
                        array(
                            'text' => Loc::getMessage('GRIZ_TELEGRAM_MENU_LIST_TITLE'),
                            'title' => Loc::getMessage('GRIZ_TELEGRAM_MENU_LIST_TITLE'),
                            'sort' => 10,
                            'url' => '/bitrix/admin/griz.telegram.list.actions.page.php?lang=' . urlencode(LANGUAGE_ID),
                            'icon' => 'ui-icon ui-icon-service-webform ui-icon-sm anz_appointment_list_menu_icon',
                            'page_icon' => 'griz_telegram_list_page_icon',
                        ),
                        array(
                            'text' => Loc::getMessage('GRIZ_TELEGRAM_MENU_SETTINGS_TITLE'),
                            'title' => Loc::getMessage('GRIZ_TELEGRAM_MENU_SETTINGS_TITLE'),
                            'sort' => 60,
                            'url' => '/bitrix/admin/griz.telegram.settings.page.php?lang=' . urlencode(LANGUAGE_ID),
                            'icon' => 'ui-icon ui-icon-service-wheel ui-icon-sm anz_appointment_settings_menu_icon',
                            'page_icon' => 'griz_telegram_settings_page_icon',
                        ),
                    ),
                );

                if (!isset($arGlobalMenu['global_griz_telegram'])) {
                    $arGlobalMenu['global_griz_telegram'] = array(
                        'menu_id' => 'global_menu_griz',
                        'text' => Loc::getMessage('GRIZ_TELEGRAM_MENU_GLOBAL_TITLE'),
                        'title' => Loc::getMessage('GRIZ_TELEGRAM_MENU_GLOBAL_TITLE'),
                        'sort' => 1000,
                        'icon' => 'griz_telegram_global_menu_icon',
                        'items_id' => 'global_griz_telegram',
                    );
                }

                $arGlobalMenu['global_griz_telegram']['items'][$moduleID] = $arMenu;
            }
        }
    }
}