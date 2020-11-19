<?php


namespace yii\c7v\yii_openbank_partners\dictionaries;

use http\Client\Request;
use http\Client\Response;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\base\Component;

/**
 * Class CityAndPromotion
 * @package yii\c7v\openpartners\dictionaries
 */
class CityAndPromotion extends Component
{
    const BASE_URL = 'https://openpartners.ru/api/v2/dictionaries/';

    /**
     * @var string
     */
    public $x_auth_token;
    /**
     * @var boolean
     */
    private $test;

    /**
     * @var Client
     */
    public $client;
    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;

    /**
     * CityAndPromotion constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (!empty($config['X-Auth-Token'])){
            $this->x_auth_token = $config['X-Auth-Token'];
        }else{
            if (!empty(\Yii::$app->params['X-Auth-Token'])){
                $this->x_auth_token = \Yii::$app->params['X-Auth-Token'];
            }else{
                throw new \Exception("Не установлен X-Auth-Token", 102);
            }
        }
        $this->test = false;
        if (!empty($config['test'])){
            $this->test = $config['test'];
        }
        $this->client = new Client([
            'baseUrl' => self::BASE_URL,
        ]);
        $this->request = $this->client->createRequest()->setFormat(Client::FORMAT_JSON)->setHeaders([
            'X-Auth-Token' => $this->x_auth_token,
        ]);
    }

    /**
     * @param bool $list
     * @return bool|mixed|null
     * @throws \yii\httpclient\Exception
     */
    public function getCity($list = false){
        $this->response = $this->request->setMethod("GET")->setUrl('city')->send();
        if ($this->response->isOk){
            $data = $this->response->getData();
            return $list==true ? ArrayHelper::map($data, 'city', 'city') : $data;
        }
        return false;
    }

    /**
     * @param bool $list
     * @return bool|mixed|null
     * @throws \yii\httpclient\Exception
     */
    public function getPromotion($list = false){
        $this->response = $this->request->setMethod("GET")->setUrl('promotion')->send();
        if ($this->response->isOk){
            $data = $this->response->getData()['promotions'];
            if (!empty($data)){
                return $list==true ? ArrayHelper::map($data, 'id', 'name') : $data;
            }
            return null;
        }
        return false;
    }
}