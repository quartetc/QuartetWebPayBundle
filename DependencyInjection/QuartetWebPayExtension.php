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

        $this->remapParameters($container, $configs, 'quartet_webpay.%s', array(
            'api_secret', 'api_public', 'api_base'
        ));

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yml');

        if (isset($configs['accept_language'])) {
            $container->getDefinition('quartet_webpay_client')->addMethodCall('acceptLanguage', array($configs['accept_language']));
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
