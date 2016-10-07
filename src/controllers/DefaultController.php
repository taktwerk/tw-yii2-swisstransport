<?php
namespace taktwerk\swisstransport\controllers;

use taktwerk\swisstransport\components\Connection;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $connection = new Connection();
        $busLines = $connection->getNext();
        return $this->renderAjax('/swisstransport/index', compact('busLines'));
    }
}