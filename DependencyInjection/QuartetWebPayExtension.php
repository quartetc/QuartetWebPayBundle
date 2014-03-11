<?php

namespace Quartet\WebPayBundle\DependencyInjection;


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

        if (!empty($configs['checkout'])) {
            $this->loadCheckout($configs['checkout'], $container, $loader);
        }

        if (!empty($configs['customer'])) {
            $this->loadCustomer($configs['customer'], $container, $loader);
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
     * @param array            $configs
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function loadCheckout(array $configs, ContainerBuilder $container, LoaderInterface $loader)
    {
        $loader->load('checkout.yml');

        $container->setParameter('quartet_webpay.checkout.payment_class', $configs['payment_class']);

        $this->loadCheckoutPayment($configs['payment'], $container);
        $this->loadCheckoutService($configs['service'], $container);
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function loadCheckoutPayment(array $configs, ContainerBuilder $container)
    {
        $container->setParameter('quartet_webpay.checkout.payment.tokenize', $configs['tokenize']);
        $container->setParameter('quartet_webpay.checkout.payment.persistence', $configs['persistence']);

        $definition = $container->getDefinition('quartet_webpay.checkout.payment.form_factory');
        $definition->addArgument($configs['form']['name']);
        $definition->addArgument($configs['form']['type']);
        $definition->addArgument($configs['tokenize']);
        $definition->addArgument($configs['persistence'] === 'optional');

        $container->setAlias('quartet_webpay.checkout.payment_handler', $configs['handler']);
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    private function loadCheckoutService(array $configs, ContainerBuilder $container)
    {
        foreach ($configs as $name => $id) {
            $container->setAlias(sprintf('quartet_webpay.checkout.%s', $name), $id);
        }
    }

    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    private function loadCustomer(array $configs, ContainerBuilder $container, LoaderInterface $loader)
     {
        $loader->load('customer.yml');

        $container->setAlias('quartet_webpay.customer_manager', $configs['manager']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'quartet_webpay';
    }
}
