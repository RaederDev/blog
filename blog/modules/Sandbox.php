<?php

namespace modules;

use Craft;
use Twig_Extension_Sandbox;

class Sandbox
{

    //https://twig.symfony.com/doc/2.x/api.html#sandbox-extension
    private static $allowedTags = [
        'autoescape',
        'filter',
        'do',
        'flush',
        'for',
        'set',
        'verbatim',
        'if',
        'spaceless',
    ];

    private static $allowedFilters = [
        'abs',
        'batch',
        'capitalize',
        'convert_encoding',
        'date',
        'date_modify',
        'default',
        'escape',
        'first',
        'format',
        'join',
        'json_encode',
        'keys',
        'last',
        'length',
        'lower',
        'merge',
        'nl2br',
        'number_format',
        'raw',
        'replace',
        'reverse',
        'round',
        'slice',
        'sort',
        'split',
        'striptags',
        'title',
        'trim',
        'upper',
        'url_encode',
    ];

    private static $allowedFunctions = [
        'attribute',
        'cycle',
        'date',
        'dump',
        'max',
        'min',
        'random',
        'range',
    ];

    private static $allowedMethods = [];

    private static $allowedProperties = [];

    public static function addTwigSandbox()
    {
        Craft::$app
            ->getView()
            ->registerTwigExtension(
                new Twig_Extension_Sandbox(self::buildPolicy())
            );
    }

    private static function buildPolicy(): \Twig_Sandbox_SecurityPolicyInterface
    {
        return new \Twig_Sandbox_SecurityPolicy(
            self::$allowedTags,
            self::$allowedFilters,
            self::$allowedMethods,
            self::$allowedProperties,
            self::$allowedFunctions
        );
    }

}
