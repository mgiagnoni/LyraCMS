#!/usr/bin/env php
<?php

/*
 * This file is part of Lyra CMS.
 *
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

/**
 * Script to build bootstrap cache.
 *
 * This is a slightly modified version of the file included in the
 * SensioDistributionBundle distributed with Symfony Standard Edition.
 *
 * @author   Fabien Potencier <fabien@symfony.com>
 * @license  http://www.symfony-project.org/license MIT
 */

require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\ClassCollectionLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array('Symfony' => __DIR__.'/../vendor/symfony/src'));
$loader->register();

$file = __DIR__.'/../app/bootstrap.php.cache';
if (file_exists($file)) {
    unlink($file);
}

ClassCollectionLoader::load(array(
    'Symfony\\Component\\DependencyInjection\\ContainerAwareInterface',
    'Symfony\\Component\\DependencyInjection\\ContainerAware',
    'Symfony\\Component\\DependencyInjection\\ContainerInterface',
    'Symfony\\Component\\DependencyInjection\\Container',
    'Symfony\\Component\\HttpKernel\\HttpKernelInterface',
    'Symfony\\Component\\HttpKernel\\KernelInterface',
    'Symfony\\Component\\HttpKernel\\Kernel',
    'Symfony\\Component\\ClassLoader\\ClassCollectionLoader',
    'Symfony\\Component\\ClassLoader\\UniversalClassLoader',
    'Symfony\\Component\\HttpKernel\\Bundle\\Bundle',
    'Symfony\\Component\\HttpKernel\\Bundle\\BundleInterface',
    'Symfony\\Component\\Config\\ConfigCache',
    // cannot be included as commands are discovered based on the path to this class via Reflection
    //'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
), dirname($file), basename($file, '.php.cache'), false, false, '.php.cache');

file_put_contents($file, "<?php\n\nnamespace { require_once __DIR__.'/autoload.php'; }\n\n".substr(file_get_contents($file), 5));
