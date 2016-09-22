<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest;
use skeeks\cms\base\Component;
use skeeks\yii2\dadataSuggestApi\DadataSuggestApi;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class CmsAgentComponent
 * @package skeeks\cms\agent
 */
class CmsDadataSuggestApi extends DadataSuggestApi
{
    public function init()
    {
        parent::init();

        if (\Yii::$app->dadataSuggest->authorization_token)
        {
            $this->authorization_token = \Yii::$app->dadataSuggest->authorization_token;
        }
    }
}