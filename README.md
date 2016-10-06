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
    ],
],
```
