<?php

namespace Schnittstabil\Sugared\PHP\CodeSniffer;

class CLITest extends \PHPUnit_Framework_TestCase
{
    public function testProcessConfigShouldNotSetFiles()
    {
        $sut = new CLI();
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('files'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('processConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('files'));
    }

    public function testgetCommandLineValuesShouldReturnFiles()
    {
        $sut = new CLI();
        $sut->setCommandLineValues([]);
        $values = $sut->getCommandLineValues();
        $expected = array_map('realpath', DefaultPreset::get()['files']);

        $this->assertSame($expected, $values['files']);
    }

    public function testgetCommandLineValuesShouldReturnOverwritenFiles()
    {
        $sut = new CLI();
        $sut->setCommandLineValues(['sugared-phpcs']);
        $values = $sut->getCommandLineValues();

        $this->assertSame([realpath('sugared-phpcs')], $values['files']);
    }

    public function testgetCommandLineValuesShouldReturnNamespacedConfig()
    {
        $sut = new CLI();
        $sut->setCommandLineValues([
            '--report=summary',
            '--namespace=schnittstabil/sugared-php_codesniffer test namespace',
        ]);
        $values = $sut->getCommandLineValues();

        $this->assertSame([realpath('tests')], $values['files']);
    }

    public function testProcessConfigShouldNotSetPresets()
    {
        $sut = new CLI();
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('presets'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('processConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('presets'));
    }
}
