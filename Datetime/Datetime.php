<?php

namespace Datetime;

/**
 * DateTime extension class to add the function: addBussinessDays in PHP's Default DateTime Class
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
     * Generates the starting date based on the day of the week 
     */ 
    private function startDate()
    {
        if ($this->format('w') == 6) {
            $this->modify('+1 day');
        } elseif ($this->format('w') == 7) {
            $this->modify('+2 day');
        }
    }

    
    /**
     * Add business days, considering saturnday and sunday as non-business days
     * @param int $businessDays
     */ 
    public function addBusinessDays($businessDays, $holydays = false)
    {   
        if(!$holydays){
            $this->startDate();
        }
        
        $startDate = clone $this;

        $this->modify('+'.$businessDays.' day');

        $every5Days = floor($businessDays / 5) * 2;

        $this->modify('+'.$every5Days.' day');

        if (($businessDays % 5) + $startDate->format('w') >= 6) {
            $this->modify('+2 day');
        }

    }

    /**
     * Add business days, considering saturnday, sunday and holydays as non-business days
     * @param int $businessDays
     */ 
    public function addBusinessDaysWithHolydays($businessDays)
    {
        $this->startDate();

        $startDate = clone $this;
        $addDays = $businessDays;

        while ($businessDays > 1) {
            
            $startDate->addBusinessDays(1, true);
            
            if (!in_array($startDate->format('Y-m-d'), $this->holydays)) {
                 $businessDays--;
            } else {
                $addDays++;
            }
        }

        $this->addBusinessDays($addDays, true);

        if (in_array($this->format('Y-m-d'), $this->holydays)) {
            $this->addBusinessDaysWithHolydays(1);
        }
    }
}
