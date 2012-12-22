<?php

namespace Wrath\ItemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LineItem
 *
 * @ORM\Table(name="line_items")
 * @ORM\Entity
 */
class LineItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \Wrath\ItemBundle\Entity\Manifest $manifest
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\ItemBundle\Entity\Manifest")
     * @ORM\JoinColumn(name="manifest_id", referencedColumnName="id")
     */
    private $manifest;

    /**
     * @var \Wrath\ItemBundle\Entity\Item $item
     *
     * @ORM\ManyToOne(targetEntity="Wrath\ItemBundle\Entity\Item", cascade={"persist"})
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="current_value", type="integer")
     */
    private $current_value;


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
     * Set item
     *
     * @param \Wrath\ItemBundle\Entity\Item $item
     * @return LineItem
     */
    public function setItem(\Wrath\ItemBundle\Entity\Item $item = null)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return \Wrath\ItemBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return LineItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set current_value
     *
     * @param float $currentValue
     * @return LineItem
     */
    public function setCurrentValue($currentValue)
    {
        $this->current_value = $currentValue;
    
        return $this;
    }

    /**
     * Get current_value
     *
     * @return float 
     */
    public function getCurrentValue()
    {
        return $this->current_value;
    }

    /**
     * Set manifest
     *
     * @param \Wrath\ItemBundle\Entity\Manifest $manifest
     * @return LineItem
     */
    public function setManifest(\Wrath\ItemBundle\Entity\Manifest $manifest = null)
    {
        $this->manifest = $manifest;
    
        return $this;
    }

    /**
     * Get manifest
     *
     * @return \Wrath\ItemBundle\Entity\Manifest 
     */
    public function getManifest()
    {
        return $this->manifest;
    }
    
    /**
     * @return float
     */
    public function getTotalValue()
    {
        return $this->getQuantity() * $this->getCurrentValue();
    }
}