<?php

namespace Griz\Telegram\Internals\Control;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Extension;
use Exception;

class ServiceManager
{

    const OPTION_KEY_AUTO_INC               = 'appointment_settings_use_auto_injecting';

    public static function getModuleId(): string
    {
        return 'griz.telegram';
    }

    /**
     * @throws \Exception
     */
    public static function includeAppointmentExtension(): void
    {
        $useAutoInc     = Option::get(static::getModuleId(), self::OPTION_KEY_AUTO_INC) === "Y";
        $isAdminSection = Context::getCurrent()->getRequest()->isAdminSection();
        if ($useAutoInc && !$isAdminSection && !ServiceManager::isModuleInstallingNow())
        {
            global $APPLICATION;

            $extensionId = defined('ANZ_APPOINTMENT_JS_EXTENSION') ? constant('ANZ_APPOINTMENT_JS_EXTENSION') : Constants::APPOINTMENT_JS_EXTENSION;

            $currentUserGroups = !empty($GLOBALS['USER']) ? CurrentUser::get()->getUserGroups() : [];

            $canSeeForm = ($APPLICATION->GetGroupRight(static::getModuleId(), $currentUserGroups) >= "R");
            $isAdmin = !empty($GLOBALS['USER']) && CurrentUser::get()->isAdmin();

            if ( $canSeeForm || $isAdmin )
            {
                Extension::load($extensionId);
            }
        }
    }

}