<?php

namespace Melody\Datetime;

/**
 * DateTime extension class to add the function: addBusinessDays
 * and addBusinessDaysWithHolidays in PHP's Default DateTime Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DateTime extends \DateTime
{

    /**
     * Define the holidays that will be considerated on the algorithm
     */
    private $holidays = array();

    /**
     * Set Holidays
     * @param array $holidays 
     */
    public function setHolidays($holidays)
    {
        $this->holidays = $holidays;
    }

    /**
     * @param DateTime $date
     * @return bool
     */
    protected function isHoliday(DateTime $date)
    {
        if (in_array($date->format('Y-m-d'), $this->holidays)) {
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
     * Add business days, considering saturgday, sunday and holidays as non-business days
     * @param int $businessDays
     */
    public function addBusinessDaysWithHolidays($businessDays)
    {
        $clone = clone $this;
        $addDays = $businessDays;

        while ($businessDays >= 1) {
            $clone->addBusinessDays(1);
            
            if (!$this->isHoliday($clone)) {
                $businessDays--;
                continue;
            }

            $addDays++;
        }

        $this->addBusinessDays($addDays, true);
    }
}
