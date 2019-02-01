<?php

namespace modules;

use \RuntimeException;

class H2PushHelper extends \Twig_Extension
{

    public static $assetsToPush = [];

    // https://fetch.spec.whatwg.org/#concept-request-destination
    private static $autoDetectTypes = [
        "/\.js(\?.*)?$/i" => 'script',
        "/\.css(\?.*)?$/i" => 'style',
        "/\.(jpe?g|png|gif|apng|tiff|bmp|webp|ico)(\?.*)?$/i" => 'image',
    ];

    public function h2Push(string $input, $type = null, $crossorigin = false): string
    {
        if (!empty(self::$assetsToPush[$input])) {
            return $input;
        }

        //no type specified
        if ($type === null) {
            foreach (self::$autoDetectTypes as $regex => $pushType) {
                if (preg_match($regex, $input)) {
                    $type = $pushType;
                    break;
                }
            }
        }

        //no type specified and auto detect failed
        if ($type === null) {
            throw new RuntimeException("Could not detect h2 push type for asset $input, please specify in filter.");
        }

        self::$assetsToPush[$input] = [
            'type' => $type,
            'crossorigin' => $crossorigin,
        ];

        //pass back input to template
        return $input;
    }

    public function getFilters(): array
    {
        return [
            new \Twig_Filter('h2push', [$this, 'h2Push']),
        ];
    }

}
