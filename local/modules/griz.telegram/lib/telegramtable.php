<?php

namespace Griz\Telegram;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;

Loc::loadMessages(__FILE__);

class TelegramTable extends DataManager
{
    // название таблицы
    public static function getTableName()
    {
        return 'griz_telegram_integration';
    }

    // создаем поля таблицы
    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true
            )),// autocomplite с первичным ключом
            new StringField('NAME', array(
                'required' => true,
                'title' => Loc::getMessage('MYMODULE_NAME'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_NAME_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                },
            )),//обязательная строка с default значением и длиной не более 255 символов
            new StringField('ADRESS', array(
                'required' => false,
                'title' => Loc::getMessage('MYMODULE_ADRESS'),
                'default_value' => function () {
                    return Loc::getMessage('MYMODULE_ADRESS_DEFAULT_VALUE');
                },
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                }
            )),//обязательная строка с default значением  и длиной не более 255 символов
            new DatetimeField('UPDATED_AT', array(
                'required' => true)),//обязательное поле даты
            new DatetimeField('CREATED_AT', array(
                'required' => true)),//обязательное поле даты
        );
    }
}