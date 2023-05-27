<?php
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2022
 * ==================================================
 * "Bit.Umc - Bitrix integration" - OptionManager.php
 * 10.07.2022 22:37
 * ==================================================
 */
namespace Griz\Telegram\Config;

use Bitrix\Main\Localization\Loc;

/**
 * @class OptionList
 * @package Griz\Telegram\Config
 */
class OptionList extends BaseOptionManager
{
    /**
     * @param string $moduleId
     * @throws \Exception
     */
    public function __construct(string $moduleId)
    {
        parent::__construct($moduleId);
        Loc::loadMessages(__FILE__);
    }

    /**
     * @return void
     */
    protected function setTabs(): void
    {
        $this->tabs = [
            [
                'DIV'   => "settings_tab",
                'TAB'   => Loc::getMessage("GRIZ_STUDIO_MODULE_SETTINGS"),
                'ICON'  => '',
                'TITLE' => Loc::getMessage("GRIZ_STUDIO_MODULE_SETTINGS"),
                "OPTIONS" => [
                    Loc::getMessage("GRIZ_STUDIO_TELEGRAM_API_SETTINGS"),
                    [
                        Constants::OPTION_TELEGRAM_API_TOKEN,
                        Loc::getMessage("GRIZ_STUDIO_TELEGRAM_API_TOKEN"),
                        "bot123456:ABC-DEF1234ghIkl-..... - example",
                        ['text', 50]
                    ],
                    [
                        Constants::OPTION_TELEGRAM_CHAT_ID,
                        Loc::getMessage("GRIZ_STUDIO_TELEGRAM_CHAT_ID"),
                        "34225235",
                        ['text', 50]
                    ],

                    Loc::getMessage("GRIZ_STUDIO_TELEGRAM_CHAT_SMS_TYPE"),
                    [
                        Constants::OPTION_TELEGRAM_CHAT_TYPE,
                        Loc::getMessage('GRIZ_STUDIO_TELEGRAM_CHAT_SMS_VAL'),
                        "N",
                        ['checkbox']
                    ],
                    [ 'note' => Loc::getMessage('GRIZ_STUDIO_TELEGRAM_CHAT_SMS_MESSAGE')],
                ]
            ],
            [
                'DIV'       => "testing_tab",
                'TAB'       => Loc::getMessage("GRIZ_STUDIO_MODULE_TAB_TESTING"),
                'ICON'      => '',
                'TITLE'     => Loc::getMessage("GRIZ_STUDIO_MODULE_TAB_TESTING"),
                'OPTIONS'   => [
                    Loc::getMessage("ANZ_APPOINTMENT_LOGO_UPLOAD"),
                    [
                        Constants::OPTION_KEY_LOGO,
                        Loc::getMessage("ANZ_APPOINTMENT_LOGO_UPLOAD"),
                        "",
                        ['file']
                    ],
                    Loc::getMessage("ANZ_APPOINTMENT_MAIN_BTN_SETTINGS"),
                    [
                        Constants::OPTION_KEY_USE_CUSTOM_BTN,
                        Loc::getMessage("ANZ_APPOINTMENT_USE_CUSTOM_MAIN_BTN"),
                        "N",
                        ['checkbox']
                    ],
                    [
                        Constants::OPTION_KEY_CUSTOM_BTN_ID,
                        Loc::getMessage("ANZ_APPOINTMENT_CUSTOM_BTN_ID"),
                        "",
                        ['text', "50"]
                    ],
                    [
                        Constants::OPTION_KEY_MAIN_BTN_BG,
                        Loc::getMessage("ANZ_APPOINTMENT_MAIN_BTN_BG_COLOR"),
                        "#025ea1",
                        ['colorPicker']
                    ],
                    [
                        Constants::OPTION_KEY_MAIN_BTN_TEXT_CLR,
                        Loc::getMessage("ANZ_APPOINTMENT_MAIN_BTN_TEXT_COLOR"),
                        "#fff",
                        ['colorPicker']
                    ],

                    Loc::getMessage("ANZ_APPOINTMENT_FORM_COLORS_SETTINGS"),
                    [
                        Constants::OPTION_KEY_FORM_BG,
                        Loc::getMessage("ANZ_APPOINTMENT_FORM_COLOR_MAIN"),
                        "#025ea1",
                        ['colorPicker']
                    ],
                    [
                        Constants::OPTION_KEY_FIELD_BG,
                        Loc::getMessage("ANZ_APPOINTMENT_FORM_COLOR_FIELD"),
                        "#1B3257",
                        ['colorPicker']
                    ],
                    [
                        Constants::OPTION_KEY_FORM_TEXT_CLR,
                        Loc::getMessage("ANZ_APPOINTMENT_FORM_COLOR_TEXT"),
                        "#f5f5f5",
                        ['colorPicker']
                    ],
                    [
                        Constants::OPTION_KEY_FORM_BTN_BG,
                        Loc::getMessage("ANZ_APPOINTMENT_FORM_COLOR_BTN"),
                        "#12b1e3",
                        ['colorPicker']
                    ],
                    [
                        Constants::OPTION_KEY_FORM_BTN_TEXT_CLR,
                        Loc::getMessage("ANZ_APPOINTMENT_FORM_COLOR_BTN_TEXT"),
                        "#ffffff",
                        ['colorPicker']
                    ],
                ]
            ],
            [
                'DIV'   => "access_tab",
                'TAB'   => Loc::getMessage("ANZ_APPOINTMENT_TAB_RIGHTS"),
                'ICON'  => '',
                'TITLE' => Loc::getMessage("ANZ_APPOINTMENT_TAB_TITLE_RIGHTS"),
            ]
        ];
    }
}