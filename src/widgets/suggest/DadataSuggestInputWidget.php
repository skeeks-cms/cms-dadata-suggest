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

    public $type    = 'ADDRESS';
    public $count   = 10;
    public $hint    = '';
    /**
     * @var string
     */
    public $addon    = ''; //clear

    public function init()
    {
        parent::init();

        //$this->options['id'] = $this->id;
        Html::addCssClass($this->options, ['form-control']);

        $this->clientOptions['id'] = $this->options['id'];
        $this->clientOptions['backend'] = Url::to('/dadataSuggest/backend/save-address');

        if ($this->hint)
        {
            $this->clientOptions['suggestOptions']['hint'] = $this->hint;
        }

        if ($this->addon)
        {
            $this->clientOptions['suggestOptions']['addon'] = $this->addon;
        }

        $this->clientOptions = ArrayHelper::merge([
            'suggestOptions' =>
            [
                'serviceUrl'    => \Yii::$app->dadataSuggestApi->baseUrl . "/rs",
                'token'         => \Yii::$app->dadataSuggestApi->authorization_token,
                'type'          => $this->type,
                'count'         => $this->count,
            ]

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

        $jsOptions = Json::encode($this->clientOptions);

        $this->view->registerJs(<<<JS
        (function(sx, $, _)
        {
            new sx.classes.DadataSuggest({$jsOptions});
        })(sx, sx.$, sx._);
JS
);
    }
}

