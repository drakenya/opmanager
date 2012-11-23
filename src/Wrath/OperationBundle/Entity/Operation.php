<?php

namespace Wrath\OperationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Wrath\OperationBundle\Entity\Operation
 *
 * @ORM\Table(name="operations")
 * @ORM\Entity
 */
class Operation
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \Wrath\UserBundle\Entity\User $creator
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;
    
    /**
     * @var
     * 
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="operation")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id")
     */
    protected $participants;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var \DateTime $start_at
     *
     * @ORM\Column(name="start_at", type="datetime", nullable=true)
     */
    private $start_at;

    /**
     * @var \DateTime $end_at
     *
     * @ORM\Column(name="end_at", type="datetime", nullable=true)
     */
    private $end_at;

    /**
     * @var integer $total_value
     *
     * @ORM\Column(name="total_value", type="integer")
     */
    private $total_value;
    
    /**
     * @var string $status
     * 
     * @ORM\Column(name="status", type="string")
     */
    private $status;
        
    /**
     * 
     */
    public function __construct() {
        $this->participants = new ArrayCollection();
        
        $this->status = 'IN_PROGRESS';
        $this->start_at = new \DateTime('now');
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
     * Set name
     *
     * @param string $name
     * @return Operation
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set start_at
     *
     * @param \DateTime $startAt
     * @return Operation
     */
    public function setStartAt($startAt)
    {
        $this->start_at = $startAt;
    
        return $this;
    }

    /**
     * Get start_at
     *
     * @return \DateTime 
     */
    public function getStartAt()
    {
        return $this->start_at;
    }

    /**
     * Set end_at
     *
     * @param \DateTime $endAt
     * @return Operation
     */
    protected function setEndAt($endAt)
    {
        $this->end_at = $endAt;
    
        return $this;
    }
    
    public function end($endAt) {
        $this->setEndAt($endAt);
        $this->setStatus('COMPLETED');
        
        foreach($this->getParticipants() as $participant) {
            if(!$participant->getLeaveAt()) {
                $participant->setLeaveAt($endAt);
            }
        }
    }

    /**
     * Get end_at
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->end_at;
    }

    /**
     * Set total_value
     *
     * @param integer $totalValue
     * @return Operation
     */
    public function setTotalValue($totalValue)
    {
        $this->total_value = $totalValue;
    
        return $this;
    }

    /**
     * Get total_value
     *
     * @return integer 
     */
    public function getTotalValue()
    {
        return $this->total_value;
    }

    /**
     * Set creator
     *
     * @param Wrath\UserBundle\Entity\User $creator
     * @return Operation
     */
    public function setCreator(\Wrath\UserBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return Wrath\UserBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
    
    /**
     * Add participants
     *
     * @param Wrath\OperationBundle\Entity\Participant $participants
     * @return Operation
     */
    public function addParticipant(\Wrath\OperationBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param Wrath\OperationBundle\Entity\Participant $participants
     */
    public function removeParticipant(\Wrath\OperationBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
    
        /**
     * Set status
     *
     * @param string $status
     * @return Operation
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * 
     */
    public function getTotalWeight() {
        $total_weight = 0.0;
        
        foreach($this->getParticipants() as $participant) {
            $total_weight += $participant->getTotalShipWeight();
        }
        
        return $total_weight;
    }
}