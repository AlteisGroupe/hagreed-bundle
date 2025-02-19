<?php

namespace Alteis\HagreedBundle;


use Alteis\HagreedBundle\DependencyInjection\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class AlteisHagreedBundle extends AbstractBundle
{

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->registerExtension(new DependencyInjection());
    }

}