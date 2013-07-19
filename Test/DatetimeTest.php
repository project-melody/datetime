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

        $result = $date->format('d/m/Y');

        $this->assertEquals($expectedResult, $result);
    }

    
    public function providerWithHolydays(){
        $provide[] = array('2012-09-20', 3, '25/09/2012');
        $provide[] = array('2012-09-22', 3, '26/09/2012');
        $provide[] = array('2012-09-20', 10, '04/10/2012');
        $provide[] = array('2012-09-20', 15, '11/10/2012');
        $provide[] = array('2012-09-22', 9, '04/10/2012');
        $provide[] = array('2012-12-23', 2, '27/12/2012');
        $provide[] = array('2013-12-22', 2, '26/12/2013');
        $provide[] = array('2012-12-22', 4, '02/01/2013');

        return $provide;
    }

}
