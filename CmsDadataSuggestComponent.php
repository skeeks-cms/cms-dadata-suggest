<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest;
use skeeks\cms\base\Component;
use Yii;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
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

    /**
     * @return array
     */
    public function getAddress()
    {
        $dataFromSession = \Yii::$app->session->get($this->sessionName);
        if ($dataFromSession)
        {
            \Yii::info('Address from session', self::className());
            return $dataFromSession;
        }

        $response = \Yii::$app->dadataSuggestApi->detectAddressByIp(\Yii::$app->request->userIP);

        if ($response->isOk)
        {
            \Yii::info('Address from api', self::className());
            $data = ArrayHelper::getValue($response->data, 'location');
            \Yii::$app->session->set($this->sessionName, $data);
            return $data;
        }

        return [];
    }

}