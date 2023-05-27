<?php

namespace Griz\Telegram\Internals\Control;

use Griz\Telegram\Controller\OneCController;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Extension;
use Exception;
use Griz\Telegram\Controller\MessageController;

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


    /**
     * @return \Griz\Telegram\Internals\Control\ServiceManager
     */
    public static function getInstance(): ServiceManager
    {
        if (static::$instance === null)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * @throws \Exception
     */
    public function includeModule(): void
    {
        $this->includeControllers();
        $this->includeDependentModules();
        $this->includeDependentExtensions();
    }

    /**
     * @throws \Bitrix\Main\LoaderException
     */
    private function includeControllers(): void
    {
        $arControllers = [
            OneCController::class  => 'lib/Controller/OneCController.php',
            MessageController::class => 'lib/Controller/MessageController.php',
        ];

        Loader::registerAutoLoadClasses(static::getModuleId(), $arControllers);
    }

    /**
     * @throws \Exception
     */
    public function includeDependentModules(): void
    {
        $dependencies = [
            'main', 'iblock'
        ];

        foreach ($dependencies as $dependency) {
            if (!Loader::includeModule($dependency)){
                throw new Exception("Can not include module '$dependency'");
            }
        }
    }

    /**
     * @return void
     * @throws \Bitrix\Main\LoaderException
     */
    public function includeDependentExtensions(): void
    {
        Extension::load([
            static::getModuleId().'.admin', "ui.icons",
        ]);
    }


}