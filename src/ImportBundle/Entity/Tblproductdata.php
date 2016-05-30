<?php

namespace ImportBundle\Entity;

/**
 * Tblproductdata
 */
class Tblproductdata
{
    /**
     * @var string
     */
    private $strproductname;

    /**
     * @var string
     */
    private $strproductdesc;

    /**
     * @var string
     */
    private $strproductcode;

    /**
     * @var \DateTime
     */
    private $dtmadded;

    /**
     * @var \DateTime
     */
    private $dtmdiscontinued;

    /**
     * @var \DateTime
     */
    private $stmtimestamp = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $intstock;

    /**
     * @var string
     */
    private $floatcostingbp;

    /**
     * @var integer
     */
    private $intproductdataid;


    /**
     * Set strproductname
     *
     * @param string $strproductname
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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

    /**
     * Get intproductdataid
     *
     * @return integer
     */
    public function getIntproductdataid()
    {
        return $this->intproductdataid;
    }
}

