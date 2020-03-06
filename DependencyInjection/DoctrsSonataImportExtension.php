<?php

namespace Sonata\ImportBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DoctrsSonataImportExtension extends Extension
{

    /**
     * @var ContainerBuilder
     */
    private $container;
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->prepairConfig($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function prepairConfig(array $config, ContainerBuilder $container) {
        $this->container = $container;

        $this->prepareConfigMappings($config);
        $this->prepareConfigEncode($config);
        $this->prepareConfigUploadDir($config);

        $parametersArray = [
            'doctrs_sonata_import.mappings'         => $config['mappings'],
            'doctrs_sonata_import.upload_dir'       => $config['upload_dir'],
            'doctrs_sonata_import.class_loaders'    => $config['class_loaders'],
            'doctrs_sonata_import.encode.default'   => $config['encode']['default'],
            'doctrs_sonata_import.encode.list'      => $config['encode']['list']
        ];

        foreach ($parametersArray as $parameterKey => $value) {
            $container->setParameter($parameterKey, $value);
        }
    }

    /**
     * @param array $config
     */
    private function prepareConfigUploadDir(array &$config) {
        $config['upload_dir'] = $config['upload_dir'] ?
            $config['upload_dir'] : $this->container->get('kernel')->getRootDir() . '/../web/uploads';
    }

    /**
     * @param array $config
     */
    private function prepareConfigEncode(array &$config) {
        if (!isset($config['encode'])) {
            $config['encode'] = [
                'default' => 'utf8',
                'list' => []
            ];
        }
    }

    /**
     * @param array $config
     */
    private function prepareConfigMappings(array &$config) {
        $config['mappings'] = array_merge($config['mappings'], [[
            'name' => 'date',
            'class' => 'doctrs.type.datetime'
        ], [
            'name' => 'datetime',
            'class' => 'doctrs.type.datetime'
        ], [
            'name' => 'boolean',
            'class' => 'doctrs.type.boolean'
        ], [
            'name' => 'integer',
            'class' => 'doctrs.type.integer'
        ], [
            'name' => 'entity',
            'class' => 'doctrs.type.entity'
        ], [
            'name' => 'choice',
            'class' => 'doctrs.type.entity'
        ]]);
    }
}
