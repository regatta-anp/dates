<?php

namespace Regatta\Dates\Iterator;

use Regatta\Dates\DateTime;
use Regatta\Dates\Range;

class SeasonsTest extends \PHPUnit_Framework_TestCase
{

    public function assertRangeSeasons($seasons, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $range = new Range($start, $end);
        $count = 0;
        foreach ($range->seasons() as $season) {
            $this->assertInstanceOf("Regatta\\Dates\\Season", $season);
            ++$count;
        }
        $this->assertSame($seasons, $count);
    }


    public function test1Season()
    {
        $this->assertRangeSeasons(1, mktime(12, 0, 0, 3, 20, 2014), mktime(12, 0, 0, 4, 20, 2014));
    }


    public function test2Seasons()
    {
        $this->assertRangeSeasons(2, mktime(12, 0, 0, 2, 1, 2014), mktime(12, 0, 0, 8, 1, 2014));
    }


    public function testYearChange()
    {
        $this->assertRangeSeasons(1, mktime(12, 0, 0, 12, 31, 2013), mktime(12, 0, 0, 1, 1, 2014));
    }


    public function testEarlyStartDate()
    {
        $this->assertRangeSeasons(1, mktime(0, 0, 0, 2, 1, 2014), mktime(12, 0, 0, 7, 15, 2014));
    }


    public function testEarlyEndDate()
    {
        $this->assertRangeSeasons(2, mktime(12, 0, 0, 5, 15, 2014), mktime(0, 0, 0, 8, 1, 2014));
    }


    public function testEarlyDates()
    {
        $this->assertRangeSeasons(4, mktime(0, 0, 0, 2, 1, 2014), mktime(0, 0, 0, 8, 1, 2015));
    }


    public function testLateStartDate()
    {
        $this->assertRangeSeasons(2, mktime(23, 59, 59, 1, 31, 2014), mktime(12, 0, 0, 6, 15, 2014));
    }


    public function testLateEndDate()
    {
        $this->assertRangeSeasons(2, mktime(12, 0, 0, 8, 15, 2014), mktime(23, 59, 59, 7, 31, 2015));
    }


    public function testLateDates()
    {
        $this->assertRangeSeasons(1, mktime(23, 59, 59, 1, 31, 2014), mktime(23, 59, 59, 1, 31, 2014));
    }


    public function testEarlyAndLateDates()
    {
        $this->assertRangeSeasons(2, mktime(0, 0, 0, 2, 1, 2014), mktime(23, 59, 59, 1, 31, 2015));
    }
}
