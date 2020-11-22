<?php


namespace yii\iesokolovskyartem\yii_openbank_partners\request;


use http\Client\Request;
use http\Client\Response;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\base\Component;

class Add extends Component
{
    const BASE_URL = 'https://openpartners.ru/api/v2/request/';

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
     * @var string Фамилия Имя Отчество, через пробел.
     */
    public $full_name;
    /**
     * @var string ИНН 10 или 12 цифр компании или ИП.
     */
    public $inn;
    /**
     * @var string Номер мобильного телефона, начинающийся с +7
     */
    public $phone;
    /**
     * @var string Город. Можно указать город который есть в списке
     * yii\websokolovsky\openpartners\dictionaries\CityAndPromotion() метод getCity();
     */
    /**
     * @var string E-mail (Электронная почта) клиента.
     */
    public $email;
    /**
     * @var string Название города, пример: Саратов
     */
    public $city;
    /**
     * @var string Комментарий. (Не обязательно)
     */
    public $comment;
    /**
     * @var ID акции, полученый из yii\websokolovsky\openpartners\dictionaries\CityAndPromotion() метод getPromotion();
     * в случае если акции есть. (Не обязетельно)
     */
    public $promotion;
    /**
     * @var array Файлы. Документы компании или индивидуального предпринимателя. (Не обязательно)
     */
    //public $files;

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
        ]);
    }

    /**
     * @param $full_name string
     * @return $this
     */
    public function setFullName($full_name){
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(){
        return $this->full_name;
    }

    /**
     * @param $inn string
     * @return $this
     */
    public function setInn($inn){
        $this->inn = $inn;
        return $this;
    }

    /**
     * @return string
     */
    public function getInn(){
        return $this->inn;
    }

    /**
     * @param $email string
     * @return $this
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * @return string string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param $phone string
     * @return $this
     */
    public function setPhone($phone){
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(){
        return $this->phone;
    }

    /**
     * @param $city string
     * @return $this
     */
    public function setCity($city){
        $this->city = $city;
        return $this;
    }

    /**
     * @return string string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * @param $comment string
     * @return $this
     */
    public function setComment($comment){
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(){
        return $this->comment;
    }

    /**
     * @param $promotion string
     * @return $this
     */
    public function setPromotion($promotion){
        $this->promotion = $promotion;
        return $this;
    }

    /**
     * @return string
     */
    public function getPromotion(){
        return $this->promotion;
    }

    /*public function setFiles($files){
        $this->files = $files;
        return $this;
    }*/

    /**
     * @param bool $list_error
     * @return bool|string
     */
    public function sendToBank($list_error = false){
        $this->response = $this->request
            ->setMethod('POST')
            //->setFormat(Client::FORMAT_CURL)
            ->setUrl($this->test ? 'add/test' : 'add')
            ->addHeaders([
                'Content-Type' => 'multipart/form-data'
            ])
            ->setData([
                'full_name' => $this->full_name,
                'inn' => $this->inn,
                'email' => $this->email,
                'phone' => $this->phone,
                'city' => $this->city,
                'comment' => $this->comment,
            ])->send();
        if ($this->response->isOk){
            return $this->response->getData()['id'];
        }
        if ($this->response->getStatusCode()==400){
            $data = $this->response->getData();
            return $list_error ? ArrayHelper::map([$data], 'error', 'description') : $data;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function findById($id){
        $this->response = $this->request
            ->setMethod('GET')
            ->setUrl($this->test ? 'status/test' : 'status')
            ->setData([
                'id' => $id
            ])->send();
        if ($this->response->isOk){
            return $this->response->getData();
        }
        return false;
    }


}