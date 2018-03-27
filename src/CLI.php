<?php

namespace SugaredRim\PHP\CodeSniffer;

class CLI extends \PHP_CodeSniffer_CLI
{
    use SugaredRimConfigAwareTrait;

    public function __construct(callable $finderByConfig = null)
    {
        $this->sugaredRimSetFinderByConfig($finderByConfig);
    }

    /**
     * @codeCoverageIgnore hard coded `exit()` in `parent::runphpcbf`
     */
    public function runphpcbf()
    {
        $this->sugaredRimProcessConfig();
        parent::runphpcbf();
    }

    /**
     * @codeCoverageIgnore hard coded `exit()` in `parent::runphpcs`
     */
    public function runphpcs()
    {
        $this->sugaredRimProcessConfig();
        parent::runphpcs();
    }
}
