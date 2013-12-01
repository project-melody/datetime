<?php

namespace Melody\Datetime;

/**
 * DateTime extension class to add the function: addBussinessDays
 * and addBusinessDaysWithHolydays in PHP's Default DateTime Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DateTime extends \DateTime
{

    /**
     * Define the holydays that will be considerated on the algorithm
     */
    private $holydays = array();

    /**
     * Set Holydays
     * @param array $holydays 
     */
    public function setHolydays($holydays)
    {
        $this->holydays = $holydays;
    }

    /**
     * @param DateTime $date
     * @return bool
     */
    protected function isHolyday(DateTime $date)
    {
        if (in_array($date->format('Y-m-d'), $this->holydays)) {
            return true;
        }

        return false;
    }

    /**
     * add business days, considering saturnday and sunday as non-business days
     * @param int $businessDays
     */
    public function addBusinessDays($businessDays)
    {
        $this->modify("+ $businessDays Weekdays");
    }


    /**
     * Add business days, considering saturgday, sunday and holydays as non-business days
     * @param int $businessDays
     */
    public function addBusinessDaysWithHolydays($businessDays)
    {
        $clone = clone $this;
        $addDays = $businessDays;

        while ($businessDays >= 1) {
            $clone->addBusinessDays(1);
            
            if (!$this->isHolyday($clone)) {
                $businessDays--;
                continue;
            }

            $addDays++;
        }

        $this->addBusinessDays($addDays, true);
    }
}

