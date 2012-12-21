<?php
// src/Wrath/UserBundle/Entity/User.php

namespace Wrath\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORm\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;
  
  /**
     * @var \Wrath\AccountingBundle\Entity\Account
     * 
     * @ORM\OneToMany(targetEntity="\Wrath\AccountingBundle\Entity\Account", mappedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $accounts;
  
  public function __construct() {
    parent::__construct();
    
    $primary_account = new \Wrath\AccountingBundle\Entity\Account();
    $primary_account->setType('PRIMARY');
    $primary_account->setUser($this);
    $this->addAccount($primary_account);
    
    $pending_account = new \Wrath\AccountingBundle\Entity\Account();
    $pending_account->setType('PENDING');
    $pending_account->setUser($this);
    $this->addAccount($pending_account);
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
     * Add accounts
     *
     * @param \Wrath\AccountingBundle\Entity\Account $accounts
     * @return User
     */
    public function addAccount(\Wrath\AccountingBundle\Entity\Account $accounts)
    {
        $this->accounts[] = $accounts;
    
        return $this;
    }

    /**
     * Remove accounts
     *
     * @param \Wrath\AccountingBundle\Entity\Account $accounts
     */
    public function removeAccount(\Wrath\AccountingBundle\Entity\Account $accounts)
    {
        $this->accounts->removeElement($accounts);
    }

    /**
     * Get accounts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAccounts()
    {
        return $this->accounts;
    }
    
    /**
     * @return \Wrath\AccountingBundle\Entity\Account
     */
    public function getPrimaryAccount()
    {
        foreach ($this->getAccounts() as $account) {
            if ($account->getType() === 'PRIMARY') {
                return $account;
            }
        }
        
        return null;
    }
    
    /**
     * 
     * @return \Wrath\AccountingBundle\Entity\Account
     */
    public function getPendingAccount()
    {
        foreach ($this->getAccounts() as $account) {
            if ($account->getType() === 'PENDING') {
                return $account;
            }
        }
        
        return null;
    }
}