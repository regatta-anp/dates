<?php

namespace Regatta\Dates;

/**
 * A class to respresent a unix timestamp and allow convenient methods.
 */
class DateTime
{
    use Traits\BankHoliday;
    use Traits\DayHelpers;
    use Traits\Formatting;
    use Traits\RelativeDateTimes;

    /**
     * @var Date $period The financial period data for this date
     */
    protected $period;


    /**
     * Create a new DateTime object representing the current time.
     *
     * @return static
     */
    public static function now()
    {
        return new static(time());
    }


    /**
     * Create a new DateTime object from a parsable date/time.
     *
     * @param string|int $date The date to parse
     * @param string|int $time The time to parse
     *
     * @return static
     */
    public static function parse($date, $time = null)
    {
        $parser = new DateTimeParser();

        $parser->addDefaultParsers();

        return $parser->parse($date, $time);
    }


    /**
     * Create a new DateTime object from a specifically formatted date/time.
     *
     * @param string $format The format that the date/time is in
     * @param string $date The date/time to parse
     *
     * @return static
     */
    public static function fromFormat($format, $date)
    {
        $datetime = \DateTime::createFromFormat($format, $date);

        $unix = $datetime->getTimestamp();

        return new static($unix);
    }


    /**
     * Create a new DateTime object from a set of individual parts.
     *
     * @param int $hour The hour
     * @param int $minute The minute
     * @param int $second The second
     * @param int $month The month
     * @param int $day The day
     * @param int $year The year
     *
     * @return static
     */
    public static function mktime($hour, $minute, $second, $month, $day, $year)
    {
        $unix = mktime($hour, $minute, $second, $month, $day, $year);

        return new static($unix);
    }


    /**
     * Create a new instance from a unix timestamp.
     *
     * @param int A unix timestamp
     */
    public function __construct($unix)
    {
        if (!$unix = (int) $unix) {
            throw new \InvalidArgumentException("An invalid unix timestamp was passed");
        }

        $this->unix = $unix;
        $this->period = null;
    }


    /**
     * Get the datetime as a unix timestamp.
     *
     * @return int
     */
    public function timestamp()
    {
        return $this->unix;
    }


    /**
     * Get a Season object for this date.
     *
     * @return Season
     */
    public function getSeason()
    {
        return new Season($this);
    }


    /**
     * Get a Month object for this date.
     *
     * @return Month
     */
    public function getMonth()
    {
        return new Month($this);
    }


    /**
     * Get a Year object for this date.
     *
     * @return Year
     */
    public function getYear()
    {
        return new Year($this);
    }


    /**
     * Get the details of the financial period for this date.
     *
     * This method will convert the result to an integer if it looks like one.
     *
     * @var string $format The format to apply to the date, only the characters m, n, y, Y and numbers may be used
     *
     * @return string|int
     */
    public function formatPeriod($format)
    {
        if ($this->period === null) {
            $this->period = new Date(mktime(12, 0, 0, $this->numeric("n") - 1, 1, $this->numeric("Y")));
        }

        if (preg_match("/[^mnyY0-9]/", $format)) {
            throw new \InvalidArgumentException("Invalid year format ({$format}), only 'm', 'n', 'y', 'Y', and numbers may be used");
        }

        return $this->period->format($format);
    }


    /**
     * Get the financial year of this date.
     *
     * @return int
     */
    public function getFinancialYear()
    {
        return (int) $this->formatPeriod("Y");
    }


    /**
     * Get the financial period of this date.
     *
     * @return int
     */
    public function getFinancialPeriod()
    {
        return (int) $this->formatPeriod("n");
    }


    /**
     * Get a unix timestamp for 12pm on this date.
     *
     * @return int
     */
    public function midday()
    {
        return mktime(12, 0, 0, $this->numeric("n"), $this->numeric("j"), $this->numeric("Y"));
    }


    /**
     * Get a unix timestamp for the start of this date.
     *
     * @return int
     */
    public function start()
    {
        return mktime(0, 0, 0, $this->numeric("n"), $this->numeric("j"), $this->numeric("Y"));
    }


    /**
     * Get a unix timestamp for the end of this date.
     *
     * @return int
     */
    public function end()
    {
        return mktime(23, 59, 59, $this->numeric("n"), $this->numeric("j"), $this->numeric("Y"));
    }
}
