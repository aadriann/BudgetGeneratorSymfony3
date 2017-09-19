<?php
/**
 * Created by PhpStorm.
 * User: Adrián
 * Date: 16/09/2017
 * Time: 20:43
 */

namespace AppBundle\Entity;


class Status
{
    private $pending = "PENDING";
    private $accepted = "ACCEPTED";
    private $discarded = "DISCARDED";

    /**
     * @return string
     */
    public function getPending()
    {
        return $this->pending;
    }

    /**
     * @return string
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * @return string
     */
    public function getDiscarded()
    {
        return $this->discarded;
    }
}