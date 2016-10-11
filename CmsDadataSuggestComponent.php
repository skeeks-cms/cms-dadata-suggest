<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest;
use skeeks\cms\base\Component;
use skeeks\yii2\dadataSuggestApi\helpers\SuggestAddressModel;
use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @property bool $isSavedAddress
 * @property SuggestAddressModel $address
 *
 * Class CmsAgentComponent
 * @package skeeks\cms\agent
 */
class CmsDadataSuggestComponent extends Component
{
    /**
     * @var string
     */
    public $authorization_token   = '';

    /**
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name'          => \Yii::t('skeeks/dadata-suggest', 'Service tips dadata.ru'),
        ]);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['authorization_token', 'string'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'authorization_token' => \Yii::t('skeeks/dadata-suggest', 'Authorization token'),
        ]);
    }

    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'authorization_token' => \Yii::t('skeeks/dadata-suggest', 'https://dadata.ru/api/'),
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('skeeks/dadata-suggest', 'Settings'));

            echo $form->field($this, 'authorization_token');

        echo $form->fieldSetEnd();
    }


    /**
     * @var string
     */
    public $sessionName = 'datataSuggest';

    private $_address = null;

    /**
     * @return null|SuggestAddressModel
     */
    public function getAddress()
    {
        if ($this->_address !== null)
        {
            return $this->_address;
        }

        $dataFromSession = \Yii::$app->session->get($this->sessionName);
        if ($dataFromSession)
        {
            \Yii::info('Address from session', self::className());
            $this->_address = new SuggestAddressModel($dataFromSession);
            return $this->_address;
        }

        $response = \Yii::$app->dadataSuggestApi->detectAddressByIp(\Yii::$app->request->userIP);

        if ($response->isOk)
        {
            \Yii::info('Address from api', self::className());
            $data = ArrayHelper::getValue($response->data, 'location');
            $this->saveAddress($data);

            $this->_address = new SuggestAddressModel($data);

            return $this->_address;
        }

        return null;
    }

    /**
     * Сохранение определенных данных
     *
     * @param array $data данные полученные из api dadata
     * @return $this
     */
    public function saveAddress($data = [])
    {
        \Yii::$app->session->set($this->sessionName, $data);
        return $this;
    }

    /**
     * Адрес сохранен в сессии?
     * @return bool
     */
    public function getIsSavedAddress()
    {
        return \Yii::$app->session->has($this->sessionName);
    }
}