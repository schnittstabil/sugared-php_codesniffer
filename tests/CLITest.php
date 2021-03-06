<?php

namespace SugaredRim\PHP\CodeSniffer;

class CLITest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        if (!class_exists(\PHP_CodeSniffer_CLI::class)) {
            $this->markTestSkipped('The \PHP_CodeSniffer_CLI class is not available.');
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testProcessConfigShouldNotSetFiles()
    {
        $sut = new CLI();
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('files'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('sugaredRimProcessConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('files'));
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testgetCommandLineValuesShouldReturnFiles()
    {
        $sut = new CLI();
        $sut->setCommandLineValues([]);
        $values = $sut->getCommandLineValues();
        $expected = array_map('realpath', array_merge(
            glob('src/*'),
            glob('tests/*.php'),
            glob('tests/fixtures/*.php')
        ));
        sort($expected);

        $actual = $values['files'];
        sort($actual);
        $this->assertSame($expected, $actual);
    }

    public function testgetCommandLineValuesShouldReturnOverwritenFiles()
    {
        $sut = new CLI();
        $sut->setCommandLineValues(['sugared-rim-phpcs']);
        $values = $sut->getCommandLineValues();

        $this->assertSame([realpath('sugared-rim-phpcs')], $values['files']);
    }

    public function testgetCommandLineValuesShouldReturnNamespacedConfig()
    {
        $sut = new CLI();
        $sut->setCommandLineValues([
            '--report=summary',
            '--namespace=sugared-rim/php_codesniffer test namespace',
        ]);
        $values = $sut->getCommandLineValues();

        $this->assertSame([realpath('tests/fixtures/a.php')], $values['files']);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testProcessConfigShouldNotSetPresets()
    {
        $sut = new CLI();
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('presets'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('sugaredRimProcessConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer::getConfigData('presets'));
    }
}
