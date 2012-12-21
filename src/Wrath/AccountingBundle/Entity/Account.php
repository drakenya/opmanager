<?php

namespace Wrath\AccountingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="accounts")
 * @ORM\Entity
 */
class Account
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
     * @var \Wrath\UserBundle\Entity\User $user
     * 
     * @ORM\ManyToOne(targetEntity="Wrath\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=32)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="balance", type="bigint")
     */
    private $balance;

    /**
     * @var float
     *
     * @ORM\Column(name="daily_interest", type="float")
     */
    private $daily_interest;

    /**
     * @var \Wrath\AccountingBundle\Entity\Transaction
     * 
     * @ORM\OneToMany(targetEntity="Transaction", mappedBy="account", cascade={"persist"})
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     */
    private $transactions;
    
    public function __construct()
    {
        $this->balance = 0;
        $this->daily_interest = 0.0;
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
     * Set creator
     *
     * @param Wrath\UserBundle\Entity\User $user
     * @return Account
     */
    public function setUser($user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return Wrath\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Account
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set balance
     *
     * @param integer $balance
     * @return Account
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    
        return $this;
    }

    /**
     * Get balance
     *
     * @return integer 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set daily_interest
     *
     * @param float $dailyInterest
     * @return Account
     */
    public function setDailyInterest($dailyInterest)
    {
        $this->daily_interest = $dailyInterest;
    
        return $this;
    }

    /**
     * Get daily_interest
     *
     * @return float 
     */
    public function getDailyInterest()
    {
        return $this->daily_interest;
    }

    /**
     * Add transactions
     *
     * @param Wrath\AccountingBundle\Entity\Transaction $transactions
     * @return Account
     */
    public function addTransaction(Transaction $transactions)
    {
        $transactions->setAccount($this);
        
        $this->transactions[] = $transactions;
        
        $this->setBalance($this->getBalance() + $transactions->getAmount());
    
        return $this;
    }

    /**
     * Remove transactions
     *
     * @param Wrath\AccountingBundle\Entity\Transaction $participants
     */
    public function removeTransaction(Wrath\AccountingBundle\Entity\Transaction $transactions)
    {
        $this->transactions->removeElement($transactions);
    }

    /**
     * Get transactions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTransactions()
    {
        return $this->transactions;
    }
}
