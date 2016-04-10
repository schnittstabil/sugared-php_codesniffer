<?php

namespace Schnittstabil\Sugared\PHP\CodeSniffer;

/**
 * @see https://github.com/squizlabs/PHP_CodeSniffer/pull/950 for details
 * @codeCoverageIgnore already tested at https://github.com/squizlabs/PHP_CodeSniffer/pull/950
 */
class MultipleStandardsCLI extends \PHP_CodeSniffer_CLI
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function validateStandard($standards)
    {
        if ($standards === null) {
            // They did not supply a standard to use.
            // Look for a default ruleset in the current directory or higher.
            $currentDir = getcwd();

            do {
                $default = $currentDir.DIRECTORY_SEPARATOR.'phpcs.xml';
                if (is_file($default) === true) {
                    return array($default);
                }

                $default = $currentDir.DIRECTORY_SEPARATOR.'phpcs.xml.dist';
                if (is_file($default) === true) {
                    return array($default);
                }

                $lastDir = $currentDir;
                $currentDir = dirname($currentDir);
            } while ($currentDir !== '.' && $currentDir !== $lastDir);

            // Try to get the default from the config system.
            $standard = \PHP_CodeSniffer::getConfigData('default_standard');
            if ($standard === null) {
                // Product default standard.
                $standard = 'PEAR';
            }

            return explode(',', $standard);
        }

        $cleaned = array();
        $standards = (array) $standards;

        // Check if the standard name is valid, or if the case is invalid.
        $installedStandards = \PHP_CodeSniffer::getInstalledStandards();
        foreach ($standards as $standard) {
            foreach ($installedStandards as $validStandard) {
                if (strtolower($standard) === strtolower($validStandard)) {
                    $standard = $validStandard;
                    break;
                }
            }

            $cleaned[] = $standard;
        }

        return $cleaned;
    }
}
