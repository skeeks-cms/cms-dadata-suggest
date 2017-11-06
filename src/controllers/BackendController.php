<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (ÑêèêÑ)
 * @date 22.09.2016
 */
namespace skeeks\cms\dadataSuggest\controllers;
use skeeks\cms\helpers\RequestResponse;
use yii\web\Controller;

/**
 * Class BackendController
 * @package skeeks\cms\dadataSuggest\controllers
 */
class BackendController extends Controller
{
    /**
     * @return RequestResponse
     */
    public function actionSaveAddress()
    {
        $rr = new RequestResponse();

        if ($location = \Yii::$app->request->post('geoobject'))
        {
            \Yii::$app->dadataSuggest->saveAddress($location);
            $rr->success = true;
        }

        return $rr;
    }

    /**
     * @return RequestResponse
     */
    public function actionGetAddress()
    {
        $rr = new RequestResponse();

        $rr->data       = [
            'geoobject' => \Yii::$app->dadataSuggest->address,
            'unrestrictedValue' => \Yii::$app->dadataSuggest->address->unrestrictedValue,
            'regionString' => \Yii::$app->dadataSuggest->address->regionString,
            'shortAddressString' => \Yii::$app->dadataSuggest->address->shortAddressString,
        ];
        $rr->success    = true;

        return $rr;
    }
}