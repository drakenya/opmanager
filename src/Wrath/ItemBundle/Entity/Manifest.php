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
     * @var \Wrath\OperationBundle\Entity\Operation $operation
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\OperationBundle\Entity\Operation")
     * @ORM\JoinColumn(name="operation_id", referencedColumnName="id")
     */
    private $operation;

    /**
     * @var \Wrath\UserBundle\Entity\User $creator
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @var
     * 
     * @ORM\OneToMany(targetEntity="LineItem", mappedBy="manifest", cascade={"persist"})
     * @ORM\JoinColumn(name="line_item_id", referencedColumnName="id")
     */
    protected $line_items;
    
    /**
     * @var \DateTime $hauled_at
     *
     * @ORM\Column(name="hauled_at", type="datetime", nullable=true)
     */
    private $hauled_at;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hauled_at = new \DateTime('now');
        $this->line_items = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set operation
     *
     * @param Wrath\OperationBundle\Entity\Operation $operation
     * @return Manifest
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    
        return $this;
    }

    /**
     * Get operation
     *
     * @return Wrath\OperationBundle\Entity\Operation 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set user
     *
     * @param Wrath\UserBundle\Entity\User $user
     * @return Manifest
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Wrath\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add line_items
     *
     * @param \Wrath\ItemBundle\Entity\LineItem $lineItems
     * @return Manifest
     */
    public function addLineItem(\Wrath\ItemBundle\Entity\LineItem $lineItems)
    {
        $lineItems->setManifest($this);
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
    
    /**
     * Get hauled_at
     *
     * @return \DateTime 
     */
    public function getHauledAt()
    {
        return $this->hauled_at;
    }
    
    /**
     * @return float
     */
    public function getTotalValue()
    {
        $total_value = 0.0;
        foreach ($this->getLineItems() as $line_item)
        {
            $total_value += ($line_item->getQuantity() * $line_item->getCurrentValue());
        }
        
        return $total_value;
    }
}