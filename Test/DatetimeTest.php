<?php
namespace Test;

require __DIR__.'/../Datetime/Datetime.php';

use Datetime\Datetime;

/**
 * Testing class DateTimeTest to test DateTime Extension Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DatetimeTest extends \PHPUnit_Framework_TestCase {
    

    /**
     * @dataProvider provider
     */ 
    public function testAddBusinessDays($start, $businessDays, $expectedResult)
    {
        $date = new Datetime($start);
        $date->addBusinessDays($businessDays);
        $result = $date->format('Y-m-d');
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerWithHolydays
     */
    public function testAddBusinessDaysWithHolyDays($start, $businessDays, $expectedResult) 
    {
        $date = new DateTime($start);
        
        $date->setHolydays(array(
            '2012-12-24',
            '2012-12-25',
            '2012-12-31',
            '2013-01-01',
            '2013-12-24',
            '2013-12-25',
        ));

        $date->addBusinessDaysWithHolydays($businessDays);

        $result = $date->format('Y-m-d');

        $this->assertEquals($expectedResult, $result);
    }

    
    public function providerWithHolydays()
    {
        $provide[] = array('2012-09-20', 3, '2012-09-25');
        $provide[] = array('2012-09-22', 3, '2012-09-26');
        $provide[] = array('2012-09-20', 10, '2012-10-04');
        $provide[] = array('2012-09-20', 15, '2012-10-11');
        $provide[] = array('2012-09-22', 9, '2012-10-04');
        $provide[] = array('2012-12-23', 2, '2012-12-27');
        $provide[] = array('2013-12-22', 2, '2013-12-26');
        $provide[] = array('2012-12-22', 4, '2013-01-02');

        return $provide;
    }

    public function provider()
    {
        $provide[] = array('2012-09-20', 3, '2012-09-25');
        $provide[] = array('2012-09-22', 3, '2012-09-27');
        $provide[] = array('2012-09-20', 10, '2012-10-04');
        $provide[] = array('2012-09-20', 15, '2012-10-11');
        $provide[] = array('2012-09-22', 9, '2012-10-05');

        return $provide;
    }

}
