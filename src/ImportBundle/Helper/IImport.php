<?php

namespace ImportBundle\Helper;

interface IImport
{
    public function getHeadersPosition();

    public function getMapping();

    public function getValueConverters();

    public function getFilters();

    public function getDestinationEntity();
}