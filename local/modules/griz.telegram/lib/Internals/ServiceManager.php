<?php

namespace Griz\Telegram\Internals;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\Extension;
use Exception;

class ServiceManager
{

    public static function getModuleId(): string
    {
        return 'griz.telegram';
    }
}