<?php

use yii\web\JsExpression;

return [
    'jsOptions' => [
        'theme' => 'default',
        'lineNumbers' => true,
        'lineWrapping' => true,
        'viewportMargin' => new JsExpression('Infinity'),
    ],
    'modes' => [
        'gfm', // the first mode is enabled by default
        'markdown',
        'htmlmixed',
        'javascript',
        'css',
        'xml',
    ],
    'addons' => [
        'mode/overlay', // needed for gfm (github flavored) mode
    ]
];
