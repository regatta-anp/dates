<?php

namespace Regatta\Dates\Traits;

use Regatta\Dates\DateTime;

/**
 * Get a new DateTime object relative to the current one
 */
trait RelativeDateTimes
{

    /**
     * Get a DateTime object for the specified number of days difference.
     *
     * @param int $days The number of days to add
     *
     * @return DateTime
     */
    public function addDays($days)
    {
        $days = (int) $days;
        if ($days === 0) {
            return $this;
        }

        return new DateTime(mktime(
            $this->numeric("H"),
            $this->numeric("i"),
            $this->numeric("s"),
            $this->numeric("n"),
            $this->numeric("j") + $days,
            $this->numeric("Y")
        ));
    }


    /**
     * Get a DateTime object for the specified number of days difference.
     *
     * @param int $days The number of days to subtract
     *
     * @return DateTime
     */
    public function subtractDays($days)
    {
        return $this->addDays($days * -1);
    }


    /**
     * Get a DateTime object for the previous day.
     *
     * @return DateTime
     */
    public function previousDay()
    {
        return $this->addDays(-1);
    }


    /**
     * Get a DateTime object for the next day.
     *
     * @return DateTime
     */
    public function nextDay()
    {
        return $this->addDays(1);
    }


    /**
     * Get a DateTime object for the specified number of months difference.
     *
     * @param int $months The number of months to add
     *
     * @return DateTime
     */
    public function addMonths($months)
    {
        $months = (int) $months;
        if ($months === 0) {
            return $this;
        }

        $date = new DateTime(mktime(
            $this->numeric("H"),
            $this->numeric("i"),
            $this->numeric("s"),
            $this->numeric("n") + $months,
            1,
            $this->numeric("Y")
        ));

        # Prevent the month from wrapping when using a date that doesn't exist in that month
        $day = $this->numeric("j");
        $max = $date->numeric("t");
        if ($day > $max) {
            $day = $max;
        }

        return new DateTime(mktime(
            $this->numeric("H"),
            $this->numeric("i"),
            $this->numeric("s"),
            $this->numeric("n") + $months,
            $day,
            $this->numeric("Y")
        ));
    }


    /**
     * Get a DateTime object for the specified number of months difference.
     *
     * @param int $months The number of months to subtract
     *
     * @return DateTime
     */
    public function subtractMonths($months)
    {
        return $this->addMonths($months * -1);
    }


    /**
     * Get a DateTime object for the previous month.
     *
     * @return DateTime
     */
    public function previousMonth()
    {
        return $this->addMonths(-1);
    }


    /**
     * Get a DateTime object for the next month.
     *
     * @return DateTime
     */
    public function nextMonth()
    {
        return $this->addMonths(1);
    }


    /**
     * Get a DateTime object for the specified number of years difference.
     *
     * @param int $years The number of years to add
     *
     * @return DateTime
     */
    public function addYears($years)
    {
        # Use addMonths to take advantage of the day wrapping handling, as years always have 12 months
        return $this->addMonths($years * 12);
    }


    /**
     * Get a DateTime object for the specified number of years difference.
     *
     * @param int $years The number of years to subtract
     *
     * @return DateTime
     */
    public function subtractYears($years)
    {
        return $this->addYears($years * -1);
    }


    /**
     * Get a DateTime object for the previous year.
     *
     * @return DateTime
     */
    public function previousYear()
    {
        return $this->addYears(-1);
    }


    /**
     * Get a DateTime object for the next year.
     *
     * @return DateTime
     */
    public function nextYear()
    {
        return $this->addYears(1);
    }


    /**
     * Get a DateTime object for the specified number of seconds difference.
     *
     * @param int $seconds The number of seconds to add
     *
     * @return DateTime
     */
    public function addSeconds($seconds)
    {
        $seconds = (int) $seconds;
        if ($seconds === 0) {
            return $this;
        }

        return new DateTime(mktime(
            $this->numeric("H"),
            $this->numeric("i"),
            $this->numeric("s") + $seconds,
            $this->numeric("n"),
            $this->numeric("j"),
            $this->numeric("Y")
        ));
    }


    /**
     * Get a DateTime object for the specified number of seconds difference.
     *
     * @param int $seconds The number of seconds to subtract
     *
     * @return DateTime
     */
    public function subtractSeconds($seconds)
    {
        return $this->addSeconds($seconds * -1);
    }


    /**
     * Get a DateTime object for the specified number of minutes difference.
     *
     * @param int $minutes The number of minutes to add
     *
     * @return DateTime
     */
    public function addMinutes($minutes)
    {
        return $this->addSeconds($minutes * 60);
    }


    /**
     * Get a DateTime object for the specified number of minutes difference.
     *
     * @param int $minutes The number of minutes to subtract
     *
     * @return DateTime
     */
    public function subtractMinutes($minutes)
    {
        return $this->addMinutes($minutes * -1);
    }

    /**
     * Get a DateTime object for the specified number of hours difference.
     *
     * @param int $hours The number of hours to add
     *
     * @return DateTime
     */
    public function addHours($hours)
    {
        return $this->addMinutes($hours * 60);
    }


    /**
     * Get a DateTime object for the specified number of hours difference.
     *
     * @param int $hours The number of hours to subtract
     *
     * @return DateTime
     */
    public function subtractHours($hours)
    {
        return $this->addHours($hours * -1);
    }
}
