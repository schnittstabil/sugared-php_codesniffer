# Sugared\PHP_CodeSniffer [![Build Status](https://travis-ci.org/schnittstabil/sugared-php_codesniffer.svg?branch=master)](https://travis-ci.org/schnittstabil/sugared-php_codesniffer) [![Coverage Status](https://coveralls.io/repos/schnittstabil/sugared-php_codesniffer/badge.svg?branch=master&service=github)](https://coveralls.io/github/schnittstabil/sugared-php_codesniffer?branch=master) [![Code Climate](https://codeclimate.com/github/schnittstabil/sugared-php_codesniffer/badges/gpa.svg)](https://codeclimate.com/github/schnittstabil/sugared-php_codesniffer)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/44d3d0b9-d0bd-4714-85d5-1a5cb34522ca/big.png)](https://insight.sensiolabs.com/projects/44d3d0b9-d0bd-4714-85d5-1a5cb34522ca)

> PHP_CodeSniffer sweetened with ease :cherries:

Sugared\PHP_CodeSniffer takes an opinionated view of code style checking with [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), it is preconfigured to get you up and running as quickly as possible.

## Install

```
$ composer require --dev schnittstabil/sugared-php_codesniffer
```

## Usage

Instead of running `phpcs` with all its options, just run `sugared-phpcs` - that's it:

```json
{
    ...
    "require-dev": {
        "schnittstabil/sugared-php_codesniffer": ...
    },
    "scripts": {
        "lint": "sugared-phpcs"
    }
}
```

## Configuration

You may overwrite some options by putting it in your `composer.json`.

See [schnittstabil/finder-by-config](https://github.com/schnittstabil/finder-by-config) for details of the `files` options.

Some of the default settings:
```json
{
    ...
    "scripts": {
        "lint": "sugared-phpcs"
    },
    "extra": {
        "schnittstabil\/sugared-php_codesniffer": {
            "default_standard": ["PSR1", "PSR2"],
            "files": {
                "in": ["."],
                "name": ["*.php"],
                "files": true,
                "exclude": [
                    "build",
                    "bower_components",
                    "node_modules",
                    "vendor"
                ],
                "ignoreDotFiles": true,
                "ignoreVCS": true
            }
        }
    }
}
```

All `extra.schnittstabil/sugared-php_codesniffer` options are passed through [PHP_CodeSniffer::setConfigData](https://github.com/squizlabs/PHP_CodeSniffer/blob/2.6.0/CodeSniffer.php#L2353), except:

* `files`: Array of files and/or directories to check.


## License

MIT © [Michael Mayer](http://schnittstabil.de)
