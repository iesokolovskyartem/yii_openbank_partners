<?php


namespace yii\iesokolovskyartem\yii_openbank_partners\request;


use http\Client\Request;
use http\Client\Response;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\base\Component;

class Duplicates extends Component
{
    const BASE_URL = 'https://openpartners.ru/api/v2/';

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
        $this->request = $this->client->createRequest()->setHeaders([
            'X-Auth-Token' => $this->x_auth_token,
        ])->setUrl($this->test ? 'request/getduplicates/test' : 'request/getduplicates');
    }

    /**
     * @param array $inns
     * @return boolean|string
     * @throws \yii\httpclient\Exception
     */
    public function setDuplicates($inns = []){
        $this->response = $this->request->setMethod("POST")->setFormat(Client::FORMAT_JSON)->setData([
            'inns' => $inns
        ])->send();
        if ($this->response->isOk){
            $data = $this->response->getData();
            return $data['id'];
        }
        return false;
    }

    /**
     * @param $id string
     * @param bool $list
     * @return array|boolean
     * @throws \yii\httpclient\Exception
     */
    public function getDuplicates($id, $list = false){
        $this->response = $this->request->setFormat(Client::FORMAT_CURL)->setMethod("GET")->setData([
            'id' => $id
        ])->send();
        if ($this->response->isOk){
            $data = $this->response->getData();
            return $list ? ($data['status']!="done") ? [
                'status' => $data['status'],
            ] : [
                'status' => $data['status'],
                'result' => (!empty($data['result']['inns'])) ? (ArrayHelper::map($data['result']['inns'], 'inn', 'inn_status')) : (null)
            ] : $data;
        }
        return false;
    }
}