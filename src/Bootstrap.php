<?php
/*
 * This file is part of the tw-yii2-swisstransport project.
 *
 * (c) Taktwerk Gmbh <http://taktwerk.com>
 */

namespace taktwerk\swisstransport;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Bootstrap registers stuff to the yii framework.
 *
 * Class Bootstrap
 * @package taktwerk\swisstransport
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap process
     * @param $app
     */
    public function bootstrap($app)
    {
        // Autoload the module
        if (!$app->hasModule('swisstransport')) {
            $app->setModule(['swisstransport' => [
                'class' => 'taktwerk\swisstransport\Module',
            ]]);
        }
    }
}
