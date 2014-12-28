<?php

namespace Melody\DateTime;

/**
 * Testing class DateTimeTest to test DateTime Extension Class
 *
 * @author Levi Henrique <contato@leviferreira.com>
 */
class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider datesWithoutHolidaysProvider
     */
    public function testAddBusinessDays($start, $businessDays, $expectedResult)
    {
        $date = new DateTime($start);
        $date->addBusinessDays($businessDays);
        $result = $date->format('Y-m-d');
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @dataProvider datesWithHolidaysProvider
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

    
    public function datesWithHolidaysProvider()
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

    public function datesWithoutHolidaysProvider()
    {
        return array(
            array('2012-09-20', 3, '2012-09-25'),
            array('2012-09-22', 3, '2012-09-26'),
            array('2012-09-20', 10, '2012-10-04'),
            array('2012-09-20', 15, '2012-10-11'),
            array('2012-09-22', 9, '2012-10-04'),
        );
    }

    /**
     * @dataProvider validDatesComparisonProvider
     */
    public function testTheMethodIsShouldReturnTrueIfADatetimeObjectIsEqualsToAGivenStringConvertedToDatetime(
        $first,
        $second
    ) {
        $this->assertTrue((new DateTime($first))->is($second));
    }

    /**
     * @dataProvider validDatesComparisonProvider
     */
    public function testTheMethodIsShouldReturnTrueIfADatetimeObjectIsEqualsToAnotherDatetimeObject(
        $first,
        $second
    ) {
        $this->assertTrue((new DateTime($first))->is(new DateTime($second)));
    }

    public function validDatesComparisonProvider()
    {
        return [
            [date("Y") . "-12-01", "12/01"],
            [date("Y") . "-12-01", date("Y") . "/12/01"],
            [date("Y") . "-12-01", date("Y") . "-12-01"],
            [date("Y") . "-12-01", date("Y") . "-12-01 00:00:00"],
            [date("Y") . "-12-01", date("Y") . "-12-01 00:00:00.000000"],
            ["today", "today"],
            ["", "now"],
            ["now", "now"],
            ["tomorrow midnight", "tomorrow"],
            ["tomorrow midnight", "+1 day 00:00:00"],
            ["tomorrow noon", "+1 day 12:00:00"],
            ["yesterday midnight", "yesterday"],
            ["yesterday midnight", "-1 day 00:00:00"],
            ["yesterday noon", "-1 day 12:00:00"],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAnInvalidArgumentExceptionShouldBeRaisedIfAnInvalidTimeStringIsPassed()
    {
        (new DateTime())->is("asdfg");
    }

    /**
     * @expectedException \Exception
     */
    public function testAnExceptionShouldBeRaisedIfAnObjectIsPassed()
    {
        (new DateTime())->is(new \stdClass());
    }

    /**
     * @dataProvider validAfterDateProvider
     */
    public function testTheMethodIsAfterShouldReturnTrueIfATimeStringIsAfterInTimeFromTheGivenString(
        $before,
        $after
    ) {
        $this->assertTrue((new DateTime($before))->isAfter($after));
    }

    /**
     * @dataProvider validAfterDateProvider
     */
    public function testTheMethodIsAfterShouldReturnFalseIfATimeStringIsNotAfterInTimeFromTheGivenString(
        $before,
        $after
    ) {
        $this->assertFalse((new DateTime($after))->isAfter($before));
    }

    /**
     * @dataProvider validAfterDateProvider
     */
    public function testTheMethodIsAfterShouldReturnTrueIfATimeStringIsAfterInTimeFromTheGivenObject(
        $before,
        $after
    ) {
        $this->assertTrue((new DateTime($before))->isAfter(new DateTime($after)));
    }

    /**
     * @dataProvider validAfterDateProvider
     */
    public function testTheMethodIsAfterShouldReturnTrueIfATimeStringIsNotAfterInTimeFromTheGivenObject(
        $before,
        $after
    ) {
        $this->assertFalse((new DateTime($after))->isAfter(new DateTime($before)));
    }

    public function validAfterDateProvider()
    {
        return [
            ["tomorrow", "today"],
            ["today", "yesterday"],
            ["February", "January"],
            ["January 2014", "December 2013"],
            ["January", "January 2000"],
            ["2014-12-12 00:00:01", "2014-12-12 00:00:00"],
            ["December 30th", "January 1st"],
            ["10 seconds ago", "10 days ago"]
        ];
    }
}
