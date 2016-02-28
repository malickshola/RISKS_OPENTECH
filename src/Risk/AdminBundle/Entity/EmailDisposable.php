<?php

namespace Risk\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailDisposable
 */
class EmailDisposable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $domain;


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
     * Set domain
     *
     * @param string $domain
     * @return EmailDisposable
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
