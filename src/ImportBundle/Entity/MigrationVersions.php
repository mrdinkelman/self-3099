<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tblmigrationversions
 *
 * @ORM\Table(name="tblMigrationVersions")
 * @ORM\Entity
 */
class MigrationVersions
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
