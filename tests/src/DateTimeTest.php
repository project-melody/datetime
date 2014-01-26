<?php


use Melody\DateTime\DateTime;

/**
 * Testing class DateTimeTest to test DateTime Extension Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DateTimeTest extends \PHPUnit_Framework_TestCase {
    

    /**
     * @dataProvider provider
     */ 
    public function testAddBusinessDays($start, $businessDays, $expectedResult)
    {
        $date = new DateTime($start);
        $date->addBusinessDays($businessDays);
        $result = $date->format('Y-m-d');
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider providerWithHolidays
     */
    public function testAddBusinessDaysWithHolidays($start, $businessDays, $expectedResult) 
    {
        $date = new DateTime($start);
        
        $date->setHolidays(array(
            '2012-12-24',
            '2012-12-25',
            '2012-12-31',
            '2013-01-01',
            '2013-12-24',
            '2013-12-25',
            '2013-07-23',
            '2013-07-24',
            '2013-07-29',
        ));

        $date->addBusinessDaysWithHolidays($businessDays);

        $result = $date->format('Y-m-d');

        $this->assertEquals($expectedResult, $result);
    }

    
    public function providerWithHolidays()
    {
        return array(
            array('2012-09-20', 3, '2012-09-25'),
            array('2012-09-22', 3, '2012-09-26'),
            array('2012-09-20', 10, '2012-10-04'),
            array('2012-09-20', 15, '2012-10-11'),
            array('2012-09-22', 9, '2012-10-04'),
            array('2012-12-23', 2, '2012-12-27'),
            array('2013-12-22', 2, '2013-12-26'),
            array('2012-12-22', 4, '2013-01-02'),
            array('2013-07-22', 3, '2013-07-30'),
        );
    }

    public function provider()
    {
        return array(
            array('2012-09-20', 3, '2012-09-25'),
            array('2012-09-22', 3, '2012-09-26'),
            array('2012-09-20', 10, '2012-10-04'),
            array('2012-09-20', 15, '2012-10-11'),
            array('2012-09-22', 9, '2012-10-04'),
        );

    }

}
