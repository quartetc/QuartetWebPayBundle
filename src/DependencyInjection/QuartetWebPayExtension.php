<?php


namespace Quartet\Bundle\WebPayBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class QuartetWebPayExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $config);

        $this->remapParameters($container, $configs, 'quartet_webpay.%s', [
            'api_secret', 'api_public', 'api_base', 'test'
        ]);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->configureApiAccessor($container);

        if (isset($configs['accept_language'])) {
            $container->getDefinition('quartet_webpay_client')->addMethodCall('acceptLanguage', [$configs['accept_language']]);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    private function configureApiAccessor(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('quartet_webpay.accessor');

        if (method_exists('Symfony\Component\DependencyInjection\Definition', 'setFactory')) {
            $definition->setFactory([new Reference('quartet_webpay_client'), '__get']);
        } else {
            $definition->setFactoryService('quartet_webpay_client')->setFactoryMethod('__get');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'quartet_webpay';
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $configs
     * @param string           $path
     * @param array            $keys
     */
    private function remapParameters(ContainerBuilder $container, array $configs, $path, array $keys)
    {
        foreach ($keys as $key) {
            $container->setParameter(sprintf($path, $key), $configs[$key]);
        }
    }
}
