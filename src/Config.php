<?php

namespace SugaredRim\PHP\CodeSniffer;

class Config extends \PHP_CodeSniffer\Config
{
    use SugaredRimConfigAwareTrait;

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function __construct(array $cliArgs = [], $dieOnUnknownArg = true, callable $finderByConfig = null)
    {
        $this->sugaredRimSetFinderByConfig($finderByConfig);
        parent::__construct($cliArgs, $dieOnUnknownArg);
    }
}
