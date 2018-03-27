<?php

namespace SugaredRim\PHP\CodeSniffer;

class Runner extends \PHP_CodeSniffer\Runner
{
    /**
     * @var string
     */
    protected $sugaredRimTrigger;

    /**
     * @inheritDoc
     */
    public function init():void
    {
        $this->config = new Config();

        // v3.* and still sucks :-(
        if ($this->sugaredRimTrigger === 'runPHPCBF') {
            if ($this->config->stdin === true) {
                $this->config->verbosity = 0;
            }
        }

        parent::init();
    }

    /**
     * @inheritDoc
     */
    public function runPHPCS()
    {
        $this->sugaredRimTrigger = 'runPHPCS';
        return parent::runPHPCS();
    }

    /**
     * @inheritDoc
     */
    public function runPHPCBF()
    {
        $this->sugaredRimTrigger = 'runPHPCBF';
        return parent::runPHPCBF();
    }
}
