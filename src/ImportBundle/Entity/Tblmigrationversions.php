<?php

namespace ImportBundle\Entity;

/**
 * Tblmigrationversions
 */
class Tblmigrationversions
{
    /**
     * @var string
     */
    private $version;


    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
}

