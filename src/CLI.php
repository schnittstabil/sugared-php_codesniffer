<?php

namespace Schnittstabil\Sugared\PHP\CodeSniffer;

use Schnittstabil\ComposerExtra\ComposerExtra;

class CLI extends MultipleStandardsCLI
{
    protected $config;
    protected $namespace = 'schnittstabil/sugared-php_codesniffer';
    protected $defaultConfig = [
        'presets' => [
            'Schnittstabil\\Sugared\\PHP\\CodeSniffer\\DefaultPreset::get',
        ],
    ];

    protected function getConfig($path = null, $default = null)
    {
        if ($this->config === null) {
            $this->config = new ComposerExtra(
                $this->namespace,
                $this->defaultConfig,
                'presets'
            );
        }

        if ($path === null) {
            $path = array();
        }

        return $this->config->get($path, $default);
    }

    public function processLongArgument($arg, $pos)
    {
        if (substr($arg, 0, 10) === 'namespace=') {
            $this->namespace = substr($arg, 10);

            return;
        }

        parent::processLongArgument($arg, $pos);
    }

    public function setCommandLineValues($args)
    {
        parent::setCommandLineValues($args);

        if (!empty($this->values['files'])) {
            return;
        }

        $files = $this->getConfig('files', []);
        foreach ((array) $files as $file) {
            $this->processUnknownArgument($file, -1);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function processConfig()
    {
        foreach ($this->getConfig() as $key => $value) {
            switch ($key) {
                case 'presets':
                case 'files':
                    continue 2;
            }

            \PHP_CodeSniffer::setConfigData($key, $value, true);
        }
    }

    /**
     * @codeCoverageIgnore hard coded `exit()` in `parent::runphpcbf`
     */
    public function runphpcbf()
    {
        $this->processConfig();
        parent::runphpcbf();
    }

    /**
     * @codeCoverageIgnore hard coded `exit()` in `parent::runphpcs`
     */
    public function runphpcs()
    {
        $this->processConfig();
        parent::runphpcs();
    }
}
