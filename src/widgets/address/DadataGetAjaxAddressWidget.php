<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 23.09.2016
 */
namespace skeeks\cms\dadataSuggest\widgets\address;

use yii\base\Widget;
use yii\helpers\Json;

/**
 * Быстрый виджет по доставке, например возле страницы 1 продукта
 *
 * Class V3toysDeliveryFastWidget
 * @package v3toys\skeeks\widgets\delivery
 */
class DadataGetAjaxAddressWidget extends Widget
{
    public static $autoIdPrefix = 'DadataGetAjaxAddressWidget';

    static public $globalIsRegisterScrips    = false;

    public function run()
    {
        $this->_registerGlobalScripts();
    }

    private function _registerGlobalScripts()
    {
        if (static::$globalIsRegisterScrips === true) {
            return;
        }

        static::$globalIsRegisterScrips = true;

        $js = \yii\helpers\Json::encode([
            'backend' => \yii\helpers\Url::to('/dadataSuggest/backend/get-address')
        ]);

$this->view->registerJs(<<<JS
    (function(sx, $, _)
    {
        sx.classes.DadataGetAjaxAddress = sx.classes.Component.extend({

            _onDomReady: function()
            {
                var self = this;

                _.delay(function()
                {
                    var AjaxQuery = sx.ajax.preparePostQuery(self.get('backend'));

                    AjaxQuery.bind('success', function(e, data)
                    {
                        self.trigger('update', data.response.data);
                    });

                    AjaxQuery.execute();
                }, 500);
            }
        });

        sx.DadataGetAjaxAddress = new sx.classes.DadataGetAjaxAddress({$js});

    })(sx, sx.$, sx._);
JS
);
    }
}