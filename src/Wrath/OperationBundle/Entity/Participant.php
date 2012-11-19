<?php

namespace Wrath\OperationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wrath\OperationBundle\Entity\Participant
 *
 * @ORM\Table(name="participants")
 * @ORM\Entity
 */
class Participant
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
     * @var \Wrath\OperationBundle\Entity\Operation $operation
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\OperationBundle\Entity\Operation")
     * @ORM\JoinColumn(name="operation_id", referencedColumnName="id")
     */
    private $operation;
    
    /**
     * @var \Wrath\UserBundle\Entity\User $user
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime $join_at
     *
     * @ORM\Column(name="join_at", type="datetime")
     */
    private $join_at;

    /**
     * @var \DateTime $start_at
     *
     * @ORM\Column(name="start_at", type="datetime", nullable=true)
     */
    private $start_at;

    /**
     * @var \DateTime $leave_at
     *
     * @ORM\Column(name="leave_at", type="datetime", nullable=true)
     */
    private $leave_at;

    /**
     * @var integer $elapsed_time
     *
     * @ORM\Column(name="elapsed_time", type="integer", nullable=true)
     */
    private $elapsed_time;

    /**
     * @var string $ship_class
     *
     * @ORM\Column(name="ship_class", type="string", length=255, nullable=true)
     */
    private $ship_class;

    /**
     * @var float $ship_weight
     *
     * @ORM\Column(name="ship_weight", type="decimal", nullable=true)
     */
    private $ship_weight;

    /**
     * @var float $time_weighted_class
     *
     * @ORM\Column(name="time_weighted_class", type="decimal", nullable=true)
     */
    private $time_weighted_class;
    
    public function __construct() {
        $this->join_at = new \DateTime('now');
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
     * Set join_at
     *
     * @param \DateTime $joinAt
     * @return Participant
     */
    public function setJoinAt($joinAt)
    {
        $this->join_at = $joinAt;
    
        return $this;
    }

    /**
     * Get join_at
     *
     * @return \DateTime 
     */
    public function getJoinAt()
    {
        return $this->join_at;
    }

    /**
     * Set start_at
     *
     * @param \DateTime $startAt
     * @return Participant
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
     * Set leave_at
     *
     * @param \DateTime $leaveAt
     * @return Participant
     */
    public function setLeaveAt($leaveAt)
    {
        $this->leave_at = $leaveAt;
    
        return $this;
    }

    /**
     * Get leave_at
     *
     * @return \DateTime 
     */
    public function getLeaveAt()
    {
        return $this->leave_at;
    }

    /**
     * Set elapsed_time
     *
     * @param integer $elapsedTime
     * @return Participant
     */
    public function setElapsedTime($elapsedTime)
    {
        $this->elapsed_time = $elapsedTime;
    
        return $this;
    }

    /**
     * Get elapsed_time
     *
     * @return integer 
     */
    public function getElapsedTime()
    {
        return $this->elapsed_time;
    }

    /**
     * Set ship_class
     *
     * @param string $shipClass
     * @return Participant
     */
    public function setShipClass($shipClass)
    {
        $this->ship_class = $shipClass;
    
        return $this;
    }

    /**
     * Get ship_class
     *
     * @return string 
     */
    public function getShipClass()
    {
        return $this->ship_class;
    }

    /**
     * Set ship_weight
     *
     * @param float $shipWeight
     * @return Participant
     */
    public function setShipWeight($shipWeight)
    {
        $this->ship_weight = $shipWeight;
    
        return $this;
    }

    /**
     * Get ship_weight
     *
     * @return float 
     */
    public function getShipWeight()
    {
        return $this->ship_weight;
    }

    /**
     * Set time_weighted_class
     *
     * @param float $timeWeightedClass
     * @return Participant
     */
    public function setTimeWeightedClass($timeWeightedClass)
    {
        $this->time_weighted_class = $timeWeightedClass;
    
        return $this;
    }

    /**
     * Get time_weighted_class
     *
     * @return float 
     */
    public function getTimeWeightedClass()
    {
        return $this->time_weighted_class;
    }

    /**
     * Set operation
     *
     * @param Wrath\OperationBundle\Entity\Operation $operation
     * @return Participant
     */
    public function setOperation(\Wrath\OperationBundle\Entity\Operation $operation = null)
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
     * @return Participant
     */
    public function setUser(\Wrath\UserBundle\Entity\User $user = null)
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
}