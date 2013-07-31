<?php

namespace Datetime;

/**
 * DateTime extension class to add the function: addBussinessDays in PHP's Default DateTime Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DateTime extends \DateTime
{

    const SATURDAY  = 6;
    const SUNDAY    = 7;

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
     * Modify DateTime Instance to add normal days.
     */ 
    protected function addDays($days) {
        $this->modify("+ $days day");
    }

    /**
     * Generates the initial date based on the day of the week 
     */ 
    protected function initialDate()
    {   
        $extraDays = 0;

        if ($this->format('w') == self::SATURDAY) {
            $extraDays = 1;
        } else if ($this->format('w') == self::SUNDAY) {
            $extraDays = 2;
        }

        $this->addDays($extraDays);
    }

    
    /**
     * add business days, considering saturnday and sunday as non-business days
     * @param int $businessDays
     * @param bool $holydays
     */ 
    public function addBusinessDays($businessDays, $holydays = false)
    {   
        if (!$holydays) {
            $this->initialDate();
        }

        $addedDays = $this->getConvertedToNormalDays($businessDays);        
        $this->addDays($addedDays);
    }

    /**
     * @param int $businessDays
     * @return int
     */
    protected function getConvertedToNormalDays($businessDays)
    {
        $days = $businessDays;
        
        if (($businessDays % 5) + $this->format('w') >= self::SATURDAY) {
            $days += 2;
        }
        
        $days += floor($businessDays / 5) * 2;

        return $days;
    }

    /**
     * Add business days, considering saturgday, sunday and holydays as non-business days
     * @param int $businessDays
     */ 
    public function addBusinessDaysWithHolydays($businessDays)
    {
        $this->initialDate();

        $clone = clone $this;
        $addDays = $businessDays;

        while ($businessDays >= 1) {
            $clone->addBusinessDays(1, true);
            
            if (!$this->isHolyday($clone)) {
                $businessDays--;
                continue;
            }

            $addDays++;
        }

        $this->addBusinessDays($addDays, true);
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
}
