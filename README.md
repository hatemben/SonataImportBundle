# Sonata Import MongoDB Bundle

Add import to sonata admin bundle with MongoDB support

[![Build Status](https://scrutinizer-ci.com/g/Doctrs/ImportBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Doctrs/ImportBundle/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Doctrs/ImportBundle/badges/quality-score.png?b=master&23)](https://scrutinizer-ci.com/g/Doctrs/ImportBundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9a073eb8-fdfe-4920-82ed-4256716febb8/mini.png)](https://insight.sensiolabs.com/projects/9a073eb8-fdfe-4920-82ed-4256716febb8)
 
  
# Installation


Install for MongoDB with vcs, documentation will be updated soon.

Run

````sh
composer require doctrs/sonata-import-bundle
````

Register the bundle in your `AppKernel.php`

````php
new Sonata\ImportBundle\DoctrsSonataImportBundle()
````

If you have not bundle `white-october/pagerfanta-bundle` register this in `AppKernel.php` too.

```php
new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
```

Add orm mapping in your config.yml

````yaml
doctrine:
    # ...
    orm:
        # ...
        entity_managers:
            default:
                mappings:
                    DoctrsSonataImportBundle: ~
````
Add settings of bundle
```yaml
doctrs_sonata_import:
    mappings:
    #   - { name: center_point, class: doctrs.form_format.point}
    #   - { name: city_autocomplete, class: doctrs.form_format.city_pa}
        - { name: date, class: doctrs.type.datetime}
        - { name: datetime, class: doctrs.type.datetime}
        - { name: boolean, class: doctrs.type.boolean}
        - { name: integer, class: doctrs.type.integer}
        - { name: entity, class: doctrs.type.entity}
        - { name: choice, class: doctrs.type.entity}
    upload_dir: %kernel.root_dir%/../web/uploads    
    class_loaders:
        - { name: CSV, class: Sonata\ImportBundle\Loaders\CsvFileLoader}
    #   - { name: XLS, class: AppBundle\Loader\Sonata\XlsFileLoader}
    encode:
        default: utf8
        list:
            - cp1251
            - utf8
            - koir8
```

Update your database

```
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
```
If you have not migrations run this
```
php app/console doctrine:schema:update --force
```

Installation of bundle success

## Change sonataAdminBundle entities

Add or change methods `configureRoutes` and `getDashboardActions` in sonata admin classes

```php
use Sonata\AdminBundle\Admin\AbstractAdmin;
...
class AnyClassAdmin extends AbstractAdmin {
...
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('import', 'import', [
            '_controller' => 'DoctrsSonataImportBundle:Default:index'
        ]);
        $collection->add('upload', '{id}/upload', [
            '_controller' => 'DoctrsSonataImportBundle:Default:upload'
        ]);
        $collection->add('importStatus', '{id}/upload/status', [
            '_controller' => 'DoctrsSonataImportBundle:Default:importStatus'
        ]);
    }
    ...
    public function getDashboardActions()
    {
        $actions = parent::getDashboardActions();

        $actions['import'] = array(
            'label'              => 'Import',
            'url'                => $this->generateUrl('import'),
            'icon'               => 'upload',
            'template'           => 'SonataAdminBundle:CRUD:dashboard__action.html.twig', // optional
        );

        return $actions;
    }
```
If you don't redefined these methods you can use trait

```php
use Sonata\ImportBundle\Admin\AdminImportTrait;
use Sonata\AdminBundle\Admin\AbstractAdmin;
...
class AnyClassAdmin extends AbstractAdmin {
...
use AdminImportTrait;
```
Both methods add in `AdminImportTrait`
