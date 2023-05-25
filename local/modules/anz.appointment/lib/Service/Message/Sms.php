<?php
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2022
 * ==================================================
 * "Bit.Umc - Bitrix integration" - Sms.php
 * 10.07.2022 22:37
 * ==================================================
 */
namespace ANZ\Appointment\Service\Message;

use Bitrix\Main\Context;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Main\Sms\Event as SmsEvent;
use Exception;
use ANZ\Appointment\Config\Constants;

/**
 * Class Sms
 * @package ANZ\Appointment\Service\Message
 */
class Sms
{
    public function __construct(){}

    /**
     * @param string $phone
     * @param string $code
     * @return \Bitrix\Main\Result
     */
    public function sendConfirmCode(string $phone, string $code): Result
    {
        $fields = [
            "USER_PHONE"    => $phone,
            "CODE"          => $code,
        ];

        return $this->send(Constants::SMS_CONFIRM_EVENT_CODE, $fields);
    }

    /**
     * @param $eventType
     * @param $fields
     * @return \Bitrix\Main\Result
     */
    public function send($eventType, $fields): Result
    {
        try {
            $sms = new SmsEvent($eventType, $fields);
            $sms->setSite(Context::getCurrent()->getSite());
            $sms->setLanguage('ru');
            return $sms->send();
        }
        catch (Exception $e){
            $res = new Result();
            $res->addError(new Error($e->getMessage()));
            return $res;
        }
    }
}