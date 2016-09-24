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
        'https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css'
    ];

    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js',
        'https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js',
        'app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];

}

