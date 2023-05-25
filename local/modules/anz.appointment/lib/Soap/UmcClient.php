<?php
/**
 * ==================================================
 * Developer: Alexey Nazarov
 * E-mail: jc1988x@gmail.com
 * Copyright (c) 2019 - 2022
 * ==================================================
 * "Bit.Umc - Bitrix integration" - UmcClient.php
 * 10.07.2022 22:37
 * ==================================================
 */
namespace ANZ\Appointment\Soap;

use ANZ\Appointment\Config\Constants;
use ANZ\Appointment\Internals\Control\ServiceManager;
use ANZ\Appointment\Service\Container;
use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Result;
use Exception;
use SimpleXMLElement;
use SoapClient;
use Bitrix\Main\Config\Option;

/**
 * Class UmcClient
 * @package ANZ\Appointment\Soap
 */
class UmcClient
{
    private SoapClient  $soapClient;
    private Result      $result;
    private bool        $createdSuccessfully;

    public function __construct(array $options = null)
    {
        $this->result = new Result();
        
        try
        {
            if (!class_exists('\SoapClient')) {
                throw new Exception(Loc::getMessage("ANZ_APPOINTMENT_SOAP_EXT_NOT_FOUND"));
            }

            if ($options === null)
            {
                $options = $this->getDefaultOptions();
            }
            else
            {
                $options = array_merge($this->getDefaultOptions(), $options);
            }

            $url = trim(Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_API_WS_URL));

            if (empty($url)){
                throw new Exception(Loc::getMessage("ANZ_APPOINTMENT_SOAP_URL_ERROR"));
            }

            $location = str_replace('?wsdl', '', $url);

            $this->soapClient = new SoapClient($url, $options);
            $this->soapClient->__setLocation($location);
            $this->createdSuccessfully = true;
        }
        catch (Exception $e)
        {
            $this->createdSuccessfully = false;
            $this->result->addError(new Error($e->getMessage()));
        }
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return \Bitrix\Main\Result
     */
    public function call(string $endpoint, array $params = []): Result
    {
        try {
            $soapParams = ['parameters' => $params];

            $response = $this->soapClient->__soapCall($endpoint, $soapParams);

            try
            {
                if ($response->return === 'Ok'){
                    return $this->result;
                }
                elseif($response->return === 'Error'){
                    throw new Exception('1c returned an unknown error to the request - ' . $endpoint);
                }

                $xml = new SimpleXMLElement($response->return);
            }
            catch(Exception $e){
                throw new Exception($e->getMessage() . " | " . $response->return);
            }

            $xmlRes = $this->handleXML($endpoint, $xml);
            if (!$xmlRes->isSuccess())
            {
                $this->result->addErrors($xmlRes->getErrors());
            }
            else{
                $this->result->setData($xmlRes->getData());
            }
        }
        catch (Exception $e){
            $this->result->addError(new Error($e->getMessage()));
        }
        return $this->result;
    }

    /**
     * @param $endpoint
     * @param \SimpleXMLElement $xml
     * @return \Bitrix\Main\Result
     * @throws \Exception
     */
    protected function handleXML($endpoint, SimpleXMLElement $xml): Result
    {
        $parser = Container::getInstance()->getXmlParser();
        $result = new Result();
        switch ($endpoint)
        {
            case Constants::CLINIC_ACTION_1C:
                $result = $parser->prepareClinicData($xml);
                break;
            case Constants::EMPLOYEES_ACTION_1C:
                $result = $parser->prepareEmployeesData($xml);
                break;
            case Constants::NOMENCLATURE_ACTION_1C:
                $result = $parser->prepareNomenclatureData($xml);
                break;
            case Constants::SCHEDULE_ACTION_1C:
                $result = $parser->prepareScheduleData($xml);
                break;
            case Constants::CREATE_RESERVE_ACTION_1C:
                $result = $parser->prepareReserveResultData($xml);
                break;
            case Constants::CREATE_ORDER_ACTION_1C:
            case Constants::CREATE_WAIT_LIST_ACTION_1C:
            case Constants::DELETE_ORDER_ACTION_1C:
                $result = $parser->prepareCommonResultData($xml);
                break;
            case Constants::GET_ORDER_STATUS_ACTION_1C:
                $result = $parser->prepareStatusResultData($xml);
                break;
            default:
                $result->addError(new Error('Unknown endpoint - '.$endpoint.'. Can not determine way to process xml'));
                break;
        }
        return $result;
    }

    /**
     * @return \Bitrix\Main\Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function isCreatedSuccessfully(): bool
    {
        return $this->createdSuccessfully;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getDefaultOptions(): array
    {
        $login      = Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_API_WS_LOGIN);
        $password   = Option::get(ServiceManager::getModuleId(), Constants::OPTION_KEY_API_WS_PASSWORD);

        if (empty($login) || empty($password)){
            throw new Exception(Loc::getMessage("ANZ_APPOINTMENT_SOAP_AUTH_ERROR"));
        }

        return [
            'login'          => $login,
            'password'       => $password,
            'stream_context' => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                    ]
                ]
            ),
            'soap_version'       => SOAP_1_2,
            'trace'              => 1,
            'connection_timeout' => 5000,
            'keep_alive'         => false,
            'cache_wsdl'         => WSDL_CACHE_NONE,
            'exceptions'         => true,
        ];
    }
}