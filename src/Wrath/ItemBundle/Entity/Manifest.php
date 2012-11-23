<?php

namespace Wrath\ItemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Manifest
 *
 * @ORM\Table(name="manifests")
 * @ORM\Entity
 */
class Manifest
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
     * @var integer
     *
     * @ORM\Column(name="operation_id", type="integer")
     */
    private $operation_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $user_id;
    
    /**
     * @var
     * 
     * @ORM\OneToMany(targetEntity="LineItem", mappedBy="manifest")
     * @ORM\JoinColumn(name="line_item_id", referencedColumnName="id")
     */
    protected $line_items;


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
     * Set operation_id
     *
     * @param integer $operationId
     * @return Manifest
     */
    public function setOperationId($operationId)
    {
        $this->operation_id = $operationId;
    
        return $this;
    }

    /**
     * Get operation_id
     *
     * @return integer 
     */
    public function getOperationId()
    {
        return $this->operation_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Manifest
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->line_items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add line_items
     *
     * @param \Wrath\ItemBundle\Entity\LineItem $lineItems
     * @return Manifest
     */
    public function addLineItem(\Wrath\ItemBundle\Entity\LineItem $lineItems)
    {
        $this->line_items[] = $lineItems;
    
        return $this;
    }

    /**
     * Remove line_items
     *
     * @param \Wrath\ItemBundle\Entity\LineItem $lineItems
     */
    public function removeLineItem(\Wrath\ItemBundle\Entity\LineItem $lineItems)
    {
        $this->line_items->removeElement($lineItems);
    }

    /**
     * Get line_items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLineItems()
    {
        return $this->line_items;
    }
}