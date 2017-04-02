<?php

/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 4/2/17
 * Time: 12:33 PM
 */
namespace Curiosity26\AngularMaterialBundle\Tests;

use Curiosity26\AngularMaterialBundle\Curiosity26AngularMaterialBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;

class AppKernel extends \Symfony\Component\HttpKernel\Kernel
{
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new Curiosity26AngularMaterialBundle(),
        ];
    }

    public function registerContainerConfiguration(
        \Symfony\Component\Config\Loader\LoaderInterface $loader
    ) {
        $loader->load(__DIR__ . '/config/config.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }
}