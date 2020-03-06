<?php


namespace Sonata\ImportBundle\Service\SonataImportType;

class IntegerType implements ImportInterface {

    public function getFormatValue($value) {
        return (int)$value;
    }

}
