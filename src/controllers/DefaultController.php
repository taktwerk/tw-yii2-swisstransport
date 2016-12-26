<?php
namespace taktwerk\swisstransport\controllers;

use taktwerk\swisstransport\components\Connection;
use taktwerk\swisstransport\exception\Exception;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $connection = new Connection();
        try {
            $busLines = $connection->getNext();
        } catch (Exception $e) {
            \Yii::error(\Yii::t('app', 'Error during API Call. Trace:') . $e->getTraceAsString(), __METHOD__);
            return $this->renderAjax('/swisstransport/error', ['error' => $e->getMessage()]);
        }
        return $this->renderAjax('/swisstransport/index', compact('busLines'));
    }
}