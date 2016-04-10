<?php

namespace Schnittstabil\Sugared\PHP\CodeSniffer;

class DefaultPreset
{
    public static function get()
    {
        return [
            'default_standard' => 'PSR1,PSR2',
            'files' => ['src', 'tests'],
        ];
    }
}
