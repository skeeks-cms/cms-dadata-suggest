<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest\widgets\suggest;

use skeeks\cms\dadataSuggest\widgets\suggest\assets\DadataSuggestWidgetAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class DadataSuggestInputWidget extends InputWidget
{
    public static $autoIdPrefix = 'DadataSuggestWidget';

    public $clientOptions = [];

    public function init()
    {
        parent::init();

        $this->options['id'] = $this->id;

        $this->clientOptions = ArrayHelper::merge([
            'serviceUrl' => \Yii::$app->dadataSuggestApi->baseUrl . "/rs",
            'token' => \Yii::$app->dadataSuggestApi->authorization_token,
            'type' => "ADDRESS",
            'count' => 10,
            'addon' => 'clear',
            'hint' => 'Вот что мы нашли',
            'onSelect' => new JsExpression(<<<JS
function(suggestion)
{
    console.log(suggestion);
}
JS
),
        ], $this->clientOptions);
    }

    public function run()
    {
        if ($this->hasModel())
        {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else
        {
            echo Html::textInput($this->name, $this->value, $this->options);
        }

        DadataSuggestWidgetAsset::register($this->view);

        $id = $this->id;

        $jsOptions = Json::encode($this->clientOptions);
        $jsGlobalOptions = Json::encode([
            'backend' => Url::to('/dadataSuggest/backend/save-address')
        ]);
        $this->view->registerJs(<<<JS
$("#{$id}").suggestions({$jsOptions});
(function(sx, $, _)
{
    sx.DadataSuggest = new sx.classes.DadataSuggest({$jsGlobalOptions});
})(sx, sx.$, sx._);
JS
);
    }
}

