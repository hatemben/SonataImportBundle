<?php

namespace Sonata\ImportBundle\Loaders;


use Symfony\Component\HttpFoundation\File\File;

interface FileLoaderInterface {

    public function setFile(File $file) : FileLoaderInterface;
    public function getIteration();

}
