<?php

namespace ImportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tblproductdata
 *
 * @ORM\Table(name="tblProductData", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity
 */
class Tblproductdata
{
    /**
     * @var integer
     *
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $intproductdataid;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     */
    private $strproductname;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $strproductdesc;

    /**
     * @var string
     *
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $strproductcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $dtmadded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $dtmdiscontinued;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=false)
     */
    private $stmtimestamp;

    /**
     * @var integer
     *
     * @ORM\Column(name="intStock", type="integer", nullable=false)
     */
    private $intstock;

    /**
     * @var string
     *
     * @ORM\Column(name="floatCostInGBP", type="decimal", precision=15, scale=2, nullable=false)
     */
    private $floatcostingbp;



    /**
     * Get intproductdataid
     *
     * @return integer 
     */
    public function getIntproductdataid()
    {
        return $this->intproductdataid;
    }

    /**
     * Set strproductname
     *
     * @param string $strproductname
     * @return Tblproductdata
     */
    public function setStrproductname($strproductname)
    {
        $this->strproductname = $strproductname;

        return $this;
    }

    /**
     * Get strproductname
     *
     * @return string 
     */
    public function getStrproductname()
    {
        return $this->strproductname;
    }

    /**
     * Set strproductdesc
     *
     * @param string $strproductdesc
     * @return Tblproductdata
     */
    public function setStrproductdesc($strproductdesc)
    {
        $this->strproductdesc = $strproductdesc;

        return $this;
    }

    /**
     * Get strproductdesc
     *
     * @return string 
     */
    public function getStrproductdesc()
    {
        return $this->strproductdesc;
    }

    /**
     * Set strproductcode
     *
     * @param string $strproductcode
     * @return Tblproductdata
     */
    public function setStrproductcode($strproductcode)
    {
        $this->strproductcode = $strproductcode;

        return $this;
    }

    /**
     * Get strproductcode
     *
     * @return string 
     */
    public function getStrproductcode()
    {
        return $this->strproductcode;
    }

    /**
     * Set dtmadded
     *
     * @param \DateTime $dtmadded
     * @return Tblproductdata
     */
    public function setDtmadded($dtmadded)
    {
        $this->dtmadded = $dtmadded;

        return $this;
    }

    /**
     * Get dtmadded
     *
     * @return \DateTime 
     */
    public function getDtmadded()
    {
        return $this->dtmadded;
    }

    /**
     * Set dtmdiscontinued
     *
     * @param \DateTime $dtmdiscontinued
     * @return Tblproductdata
     */
    public function setDtmdiscontinued($dtmdiscontinued)
    {
        $this->dtmdiscontinued = $dtmdiscontinued;

        return $this;
    }

    /**
     * Get dtmdiscontinued
     *
     * @return \DateTime 
     */
    public function getDtmdiscontinued()
    {
        return $this->dtmdiscontinued;
    }

    /**
     * Set stmtimestamp
     *
     * @param \DateTime $stmtimestamp
     * @return Tblproductdata
     */
    public function setStmtimestamp($stmtimestamp)
    {
        $this->stmtimestamp = $stmtimestamp;

        return $this;
    }

    /**
     * Get stmtimestamp
     *
     * @return \DateTime 
     */
    public function getStmtimestamp()
    {
        return $this->stmtimestamp;
    }

    /**
     * Set intstock
     *
     * @param integer $intstock
     * @return Tblproductdata
     */
    public function setIntstock($intstock)
    {
        $this->intstock = $intstock;

        return $this;
    }

    /**
     * Get intstock
     *
     * @return integer 
     */
    public function getIntstock()
    {
        return $this->intstock;
    }

    /**
     * Set floatcostingbp
     *
     * @param string $floatcostingbp
     * @return Tblproductdata
     */
    public function setFloatcostingbp($floatcostingbp)
    {
        $this->floatcostingbp = $floatcostingbp;

        return $this;
    }

    /**
     * Get floatcostingbp
     *
     * @return string 
     */
    public function getFloatcostingbp()
    {
        return $this->floatcostingbp;
    }
}
