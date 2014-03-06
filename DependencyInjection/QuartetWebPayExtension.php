<?php


namespace Quartet\Bundle\WebPayBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class QuartetWebPayExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $config);

        $container->setParameter('quartet_webpay.api_secret', $configs['api_secret']);
        $container->setParameter('quartet_webpay.api_base', $configs['api_base']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    }
}
