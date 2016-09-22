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
            'robotsContent' => \Yii::t('skeeks/dadata-suggest', 'https://dadata.ru/api/'),
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo $form->fieldSet(\Yii::t('skeeks/dadata-suggest', 'Settings'));

            echo $form->field($this, 'authorization_token');

        echo $form->fieldSetEnd();
    }


}