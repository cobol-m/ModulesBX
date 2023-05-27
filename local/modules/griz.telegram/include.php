<?php
use Griz\Telegram\Internals\Control\ServiceManager;
use Griz\Telegram\Internals\Debug\Logger;

try
{
    ServiceManager::getInstance()->includeModule();
}
catch (Throwable $e)
{
    Logger::printToFile(
        date("d.m.Y H:i:s") . '. Error on module including - ' . $e->getMessage(),
    );
}
