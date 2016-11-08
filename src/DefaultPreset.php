<?php

namespace SugaredRim\PHP\CodeSniffer;

class DefaultPreset
{
    public static function get()
    {
        $config = new \stdClass();
        $config->{'default_standard'} = ['PSR1', 'PSR2'];

        $config->files = new \stdClass();
        $config->files->in = ['.'];
        $config->files->name = ['*.php'];
        $config->files->files = true;
        $config->files->exclude = [
            'build',
            'bower_components',
            'node_modules',
            'vendor',
        ];
        $config->files->ignoreDotFiles = true;
        $config->files->ignoreVCS = true;

        return $config;
    }
}
