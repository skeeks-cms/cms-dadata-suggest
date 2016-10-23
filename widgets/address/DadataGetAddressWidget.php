<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 23.09.2016
 */
namespace skeeks\cms\dadataSuggest\widgets\address;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Быстрый виджет по доставке, например возле страницы 1 продукта
 *
 * Class V3toysDeliveryFastWidget
 * @package v3toys\skeeks\widgets\delivery
 */
class DadataGetAddressWidget extends Widget
{
    public $tag = 'a';

    public $options = [];

    public $content = '';

    /**
     * @var bool
     */
    public $isStandart = true;

    public $notSavedAddress = 'Выбрать регион';

    public function init()
    {
        parent::init();

        $this->options["id"] = $this->id;
        echo Html::beginTag($this->tag, $this->options);

    }

    public function run()
    {
        if ($this->isStandart)
        {
            if (\Yii::$app->dadataSuggest->isSavedAddress)
            {
                echo \Yii::$app->dadataSuggest->address->unrestrictedValue;
            } else
            {

                DadataGetAjaxAddressWidget::widget();

                echo $this->notSavedAddress;

                $this->view->registerJs(<<<JS
    sx.DadataGetAjaxAddress.bind('update', function(e, data)
    {
        $("#{$this->id}").empty().append(data.unrestrictedValue);
    });
JS
    );
            }
        }


        echo Html::endTag($this->tag);
    }

}