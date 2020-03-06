<?php

namespace Sonata\ImportBundle\Service\SonataImportType;

use Sonata\AdminBundle\Admin\AbstractAdmin;

interface AdminAbstractAwareInterface {
    public function setAdminAbstract(AbstractAdmin $abstractAdmin);
}
