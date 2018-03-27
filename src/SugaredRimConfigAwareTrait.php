<?php

namespace SugaredRim\PHP\CodeSniffer;

use Schnittstabil\ComposerExtra\ComposerExtra;
use Schnittstabil\FinderByConfig\FinderByConfig;

trait SugaredRimConfigAwareTrait
{
    protected $sugaredRimNamespace = 'sugared-rim/php_codesniffer';
    protected $sugaredRimfinderByConfig;
    protected $sugaredRimDefaultConfig;
    protected $sugaredRimConfig;

    protected function sugaredRimSetFinderByConfig(callable $finderByConfig = null)
    {
        if ($finderByConfig === null) {
            $finderByConfig = new FinderByConfig();
        }
        $this->sugaredRimfinderByConfig = $finderByConfig;

        $this->sugaredRimDefaultConfig = new \stdClass();
        $this->sugaredRimDefaultConfig->presets = [
            'SugaredRim\\PHP\\CodeSniffer\\DefaultPreset::get',
        ];
    }

    protected function sugaredRimGetConfig($path = null, $default = null)
    {
        if ($this->sugaredRimConfig === null) {
            $this->sugaredRimConfig = new ComposerExtra(
                $this->sugaredRimNamespace,
                $this->sugaredRimDefaultConfig,
                'presets'
            );
        }

        if ($path === null) {
            $path = array();
        }

        return $this->sugaredRimConfig->get($path, $default);
    }

    public function processLongArgument($arg, $pos)
    {
        if (substr($arg, 0, 10) === 'namespace=') {
            $this->sugaredRimNamespace = substr($arg, 10);

            return;
        }

        parent::processLongArgument($arg, $pos);
    }

    public function setCommandLineValues($args)
    {
        parent::setCommandLineValues($args);

        if (isset($this->values) && !empty($this->values['files'])) {
            // v2.*
            return;
        } elseif (isset($this->files) && !empty($this->files)) {
            // v3.*
            return;
        }

        $files = $this->sugaredRimGetConfig('files', []);

        foreach (call_user_func($this->sugaredRimfinderByConfig, $files) as $file) {
            $this->processUnknownArgument($file->getPathname(), -1);
        }
    }

    protected function sugaredRimProcessConfig()
    {
        foreach ($this->sugaredRimGetConfig() as $key => $value) {
            switch ($key) {
                case 'presets':
                case 'files':
                    continue 2;
                case 'default_standard':
                    if (is_array($value)) {
                        $value = implode(',', $value);
                    }
            }

            $this->sugaredRimSetConfigData($key, $value);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function sugaredRimSetConfigData($key, $value)
    {
        if (method_exists($this, 'setConfigData')) {
            $this->setConfigData($key, $value, true);
            return;
        }

        \PHP_CodeSniffer::setConfigData($key, $value, true);
    }
}
