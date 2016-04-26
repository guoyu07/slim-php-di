<?php
/**
 * Slim Framework PHP-DI container (https://github.com/juliangut/slim-php-di)
 *
 * @link https://github.com/juliangut/slim-php-di for the canonical source repository
 *
 * @license https://raw.githubusercontent.com/juliangut/slim-php-di/master/LICENSE
 */

namespace Jgut\Slim\PHPDI\Tests;

use Jgut\Slim\PHPDI\ContainerBuilder;

class ContainerBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $settings = [
            'settings' => [
                'php-di' => [
                    'use_autowiring' => false,
                    'use_annotations' => true,
                    'ignore_phpdoc_errors' => true,
                    'proxy_path' => 'fake/path',
                ],
            ],
        ];

        self::assertInstanceOf('\Jgut\Slim\PHPDI\Container', ContainerBuilder::build($settings));
    }

    public function testBuildCache()
    {
        $settings = [
            'settings' => [
                'php-di' => [
                    'definitions_cache' => new \Doctrine\Common\Cache\VoidCache,
                ],
            ],
        ];

        self::assertInstanceOf('\Jgut\Slim\PHPDI\Container', ContainerBuilder::build($settings));
    }

    public function testBuildDefinitions()
    {
        $settings = [
            'foo' => 'bar',
        ];

        $container = ContainerBuilder::build($settings);

        self::assertEquals('bar', $container->get('foo'));
    }

    public function testBuildDefinitionsOverride()
    {
        $definitions = [
            'settings' => 'foo',
            'foo' => 'baz',
        ];

        $container = ContainerBuilder::build([], $definitions);

        self::assertEquals('foo', $container->get('settings'));
        self::assertEquals('baz', $container->get('foo'));
    }
}
