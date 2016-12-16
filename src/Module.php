<?php
/*
 * This file is part of the tw-yii2-swisstransport project.
 *
 * (c) Taktwerk Gmbh <http://taktwerk.com>
 */

namespace taktwerk\swisstransport;

use yii\base\Module as BaseModule;
use Yii;


class Module extends BaseModule
{
    /**
     * Version of the module
     */
    const VERSION = '0.0.1';

    /**
     * @var string The API to call.
     * Doc: http://transport.opendata.ch/docs.html
     */
    public $apiUrl = 'http://transport.opendata.ch/v1/connections';

    /**
     * @var array Bus lines
     */
    public $busLines = [
        'Bus 5' => [
            'from' => 'St. Gallen, Uni/Dufourstrasse',
            'to' => [
                'St. Gallen, Bahnhof',
                'St. Gallen, Rotmonten',
            ]
        ],
        'Bus 9' => [
            'from' => 'St. Gallen, Gatterstrasse',
            'to' => [
                'St. Gallen, Bahnhof Nord',
                'St Gallen, Neudorf',
            ]
        ]
    ];

    /**
     * How much next departures to show
     * @var int
     */
    public $limit = 2;

    /**
     * Time in seconds until cache is refreshed
     * @var int
     */
    public $cacheTime = 60;
}