<?php


namespace Quartet\Bundle\WebPayBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
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
        $container->setParameter('quartet_webpay.api_public', $configs['api_public']);
        $container->setParameter('quartet_webpay.api_base', $configs['api_base']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        if (!empty($configs['form'])) {
            $this->loadForm($configs['form'], $container, $loader);
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function loadForm(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        $loader->load('form.yml');

        $container->setParameter('quartet_webpay.form.templating', $configs['templating']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'quartet_webpay';
    }
}
