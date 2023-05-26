<?php
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2023
 * ==================================================
 * Bit.Umc - Bitrix integration - Configuration.php
 * 05.03.2023 21:48
 * ==================================================
 */

namespace Griz\Telegram\Config;

use Griz\Telegram\Internals\Control\ServiceManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\Web\Json;
use Throwable;

/**
 * @class Configuration
 * @package Griz\Telegram\Config
 */
final class Configuration
{
    private static ?Configuration $instance = null;

    private function __construct(){}

    /**
     * @return \Griz\Telegram\Config\Configuration
     */
    public static function getInstance(): Configuration
    {
        if (Configuration::$instance === null)
        {
            Configuration::$instance = new Configuration();
        }
        return Configuration::$instance;
    }

    /**
     * @return string
     */
    public function getLogFilePath(): string
    {
        return '/'.ServiceManager::getModuleParentDirectoryName().'/modules/'.ServiceManager::getModuleId().'/log.txt';
    }

    /**
     * @return bool
     */
    public function isDemoModeOn(): bool
    {
        return (Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_DEMO_MODE) === 'Y');
    }

    /**
     * @return bool
     */
    public function isFtpModeOn(): bool
    {
        $request   = Context::getCurrent()->getRequest();
        $ignoreFtp = $request->getPost(Constants::REQUEST_KEY_IGNORE_FTP) === 'Y';
        $useFtp    = Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_USE_FTP_DATA) === 'Y';
        return ($useFtp && !$ignoreFtp);
    }

    /**
     * @return array
     */
    public function getFtpDirectoriesMap(): array
    {
        $map = [];
        $mapJson = Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_FTP_DATA_MAP);

        if (is_string($mapJson) && !empty($mapJson))
        {
            try
            {
                $res = Json::decode($mapJson);
                if (is_array($res))
                {
                    foreach ($res as $uid => $path)
                    {
                        if (is_string($path) && (substr($path, -1) === '/'))
                        {
                            $path = substr($path, 0, strlen($path) - 1);
                        }
                        $map[$uid] = $path;
                    }
                }
            }
            catch(Throwable $e){}
        }
        return $map;
    }

    private function __clone(){}
    public function __wakeup(){}
}