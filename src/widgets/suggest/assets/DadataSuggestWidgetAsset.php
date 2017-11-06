<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest\widgets\suggest\assets;

use skeeks\cms\base\AssetBundle;

class DadataSuggestWidgetAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/dadataSuggest/widgets/suggest/assets/src';

    public $css = [
        'plugins/suggestions/16.6/suggestions.css',
        'css/dadata-suggest-theme.css'
    ];

    public $js = [
        'plugins/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js',
        'plugins/suggestions/16.6/jquery.suggestions.min.js',
        'js/dadata-suggest.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}

