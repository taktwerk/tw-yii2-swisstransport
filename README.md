tw-yii2-swisstransport
======================

Yii2 module to add swiss transport information to your app.

Installation 
------------

Add the following in your composer.json file:

```json
"require": {
    "taktwerk/tw-yii2-swisstransport": "*"
},
```

Add the following in your modules config:

```php
'bootstrap' => [
    'taktwerk\swisstransport\Bootstrap'
],
'modules' => [
    'swisstransport' => [
        'class' => 'taktwerk\swisstransport\Module',
        'busLines' => [
            'Bus 1' => [
                // From where bus goes
                'from' => 'St. Gallen, Uni/Dufourstrasse',
                // Where bus goes to
                'to' => [
                    'St. Gallen, Bahnhof',
                    'St. Gallen, Rotmonten',
                ]
            ],
        ],
        // How much next departures to show
        'limit' => 2,
        // Time in seconds for caching API call
        'cacheTime' => 30,
    ],
],
```

Usage:
```php
<?= \taktwerk\swisstransport\widgets\DepartureWidget::widget() ?>
```

Possible to use own views by setting viewPath in module configuration, eg.
```php
'modules' => [
    'swisstransport' => [
        'class' => 'taktwerk\swisstransport\Module',
        'viewPath' => '@app/views',
],
```

