<?php

namespace Alteis\HagreedBundle\DependencyInjection;

use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class DependencyInjection extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $lang = null;
        $forceLang = null;
        if (isset($config['language'])) {
            $lang = $config['language']['lang'];
            $forceLang = $config['language']['force_lang'];
        }

        $container->setParameter('alteis_hagreed.element', $config['id']);
        $container->setParameter('alteis_hagreed.token', $config['token']);
        $container->setParameter('alteis_hagreed.cookies', $config['cookies']);
        $container->setParameter('alteis_hagreed.timeout', $config['timeout']);
        $container->setParameter('alteis_hagreed.consents_form_list', $config['consents_form_list']);

        $container->setParameter('alteis_hagreed.language', [
            'lang' => $lang,
            'force_lang' => $forceLang,
        ]);

        $loader = new PhpFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../config')
        );
        $loader->load('services.php');

    }


    public function getAlias(): string
    {
        return 'alteis_hagreed';
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'] . '/Resources/config/asset_mapper.php');

    }
}