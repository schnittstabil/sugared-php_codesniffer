<?php

namespace SugaredRim\PHP\CodeSniffer;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        if (!class_exists(\PHP_CodeSniffer\Runner::class)) {
            $this->markTestSkipped('The \PHP_CodeSniffer\Runner class is not available.');
        }

        // php_codesniffer sucks - again and again :-(
        if (defined('PHP_CODESNIFFER_CBF') === false) {
            define('PHP_CODESNIFFER_CBF', false);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testProcessConfigShouldNotSetFiles()
    {
        $sut = new Config();
        $this->assertSame(null, \PHP_CodeSniffer\Config::getConfigData('files'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('sugaredRimProcessConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer\Config::getConfigData('files'));
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testgetCommandLineValuesShouldReturnFiles()
    {
        $sut = new Config([]);
        $expected = array_map('realpath', array_merge(
            glob('src/*'),
            glob('tests/*.php'),
            glob('tests/fixtures/*.php')
        ));
        sort($expected);

        $actual = $sut->files;
        sort($actual);
        $this->assertSame($expected, $actual);
    }

    public function testgetCommandLineValuesShouldReturnXOverwritenFiles()
    {
        $sut = new Config(['sugared-rim-phpcs']);
        $this->assertSame([realpath('sugared-rim-phpcs')], $sut->files);
    }

    public function testgetCommandLineValuesShouldReturnNamespacedConfig()
    {
        $sut = new Config([
            '--report=summary',
            '--namespace=sugared-rim/php_codesniffer test namespace',
        ]);
        $this->assertSame([realpath('tests/fixtures/a.php')], $sut->files);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testProcessConfigShouldNotSetPresets()
    {
        $sut = new Config([]);
        $this->assertSame(null, \PHP_CodeSniffer\Config::getConfigData('presets'));

        $reflection = new \ReflectionClass(get_class($sut));
        $processConfig = $reflection->getMethod('sugaredRimProcessConfig');
        $processConfig->setAccessible(true);
        $processConfig->invoke($sut);
        $this->assertSame(null, \PHP_CodeSniffer\Config::getConfigData('presets'));
    }
}
