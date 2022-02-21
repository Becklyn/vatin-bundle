<?php

namespace Tests\Ddeboer\VatinBundle\Functional\app;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * @inheritDoc
     */
    public function registerBundles () : iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Ddeboer\VatinBundle\DdeboerVatinBundle(),
        ];
    }


    /**
     * @inheritdoc
     */
    protected function configureContainer (ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $loader->load(__DIR__ . "/config/config.yml");
    }
}
