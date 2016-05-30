<?php

namespace ImportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductData
 */
class ProductData
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var string
     */
    private $productDesc;

    /**
     * @var string
     */
    private $productCode;

    /**
     * @var \DateTime
     */
    private $added;

    /**
     * @var \DateTime
     */
    private $discontinued;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $stock;

    /**
     * @var string
     */
    private $costInGBP;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productName
     *
     * @param string $productName
     * @return ProductData
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string 
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productDesc
     *
     * @param string $productDesc
     * @return ProductData
     */
    public function setProductDesc($productDesc)
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    /**
     * Get productDesc
     *
     * @return string 
     */
    public function getProductDesc()
    {
        return $this->productDesc;
    }

    /**
     * Set productCode
     *
     * @param string $productCode
     * @return ProductData
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string 
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     * @return ProductData
     */
    public function setAdded($added)
    {
        $this->added = $added;

        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime 
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Set discontinued
     *
     * @param \DateTime $discontinued
     * @return ProductData
     */
    public function setDiscontinued($discontinued)
    {
        $this->discontinued = $discontinued;

        return $this;
    }

    /**
     * Get discontinued
     *
     * @return \DateTime 
     */
    public function getDiscontinued()
    {
        return $this->discontinued;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return ProductData
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return ProductData
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set costInGBP
     *
     * @param string $costInGBP
     * @return ProductData
     */
    public function setCostInGBP($costInGBP)
    {
        $this->costInGBP = $costInGBP;

        return $this;
    }

    /**
     * Get costInGBP
     *
     * @return string 
     */
    public function getCostInGBP()
    {
        return $this->costInGBP;
    }
}
