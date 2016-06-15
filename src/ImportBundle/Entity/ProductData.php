<?php
/**
 * PHP version: 5.6+
 */
namespace ImportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ForceUTF8\Encoding;

/**
 * ProductData table
 */
class ProductData
{
    /**
     * ID
     * @var integer
     */
    private $id;

    /**
     * Product name
     * @var string
     */
    private $productName;

    /**
     * Product description
     * @var string
     */
    private $productDesc;

    /**
     * Product code
     * @var string
     */
    private $productCode;

    /**
     * Added datetime
     * @var \DateTime
     */
    private $added;

    /**
     * Discontinued datetime
     * @var \DateTime
     */
    private $discontinued;

    /**
     * Update timestamp
     * @var \DateTime
     */
    private $timestamp;

    /**
     * Current stock value
     * @var integer
     */
    private $stock;

    /**
     * Current cost in pounds (GBP)
     * @var string
     */
    private $costInGBP;

    /**
     * ProductData constructor.
     */
    public function __construct()
    {
        $this->added = new \DateTime(); // init added property with default value
    }

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
     *
     * @return ProductData
     */
    public function setProductName($productName)
    {
        $this->productName = Encoding::toLatin1($productName);

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
     *
     * @return ProductData
     */
    public function setProductDesc($productDesc)
    {
        $this->productDesc = Encoding::toLatin1($productDesc);

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
     *
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
     *
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
     *
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
     *
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
     *
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
     *
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
