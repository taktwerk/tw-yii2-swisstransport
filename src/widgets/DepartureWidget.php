<?php
namespace taktwerk\swisstransport\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Url;
use yii\web\View;

class DepartureWidget extends Widget
{

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        $this->registerJs();
        return '<div id="swisstransport"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
    }

    public function registerJs()
    {
        $url = Url::toRoute(['/swisstransport'], true);
        $js = <<<JS
$(document).ready(function () {
    $.ajax('$url')
        .done(function(data) {
            $('#swisstransport').html(data);
        });
    });
JS;
        $this->view->registerJs($js, View::POS_END);
    }
}
