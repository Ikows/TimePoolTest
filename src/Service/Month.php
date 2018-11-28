<?php
/**
 * Created by PhpStorm.
 * User: ikows
 * Date: 23/11/18
 * Time: 15:02
 */

namespace App\Service;

class Month
{

    public  $days = ['Monday', 'Thursday', 'Wednesday', 'Tuesday', 'Friday', 'Saturday', 'Sunday'];
    private $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month mois entre 1 et 12
     * @param int $year année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        if ($month === null || $month < 1 || $month > 12)
        {
            $month = intval(date('m'));
        }

        if ($year === null)
        {
            $year = intval(date('Y'));
        }

        if ($year < 1970)
        {
            throw new \Exception('Omg, l\'année n\'est pas valide');
        }
        $this->month = $month;
        $this->year = $year;
    }

    public function getStartingDay(): \DateTimeInterface
    {
        return new \DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    public function getWeeks(): int
    {
        $start = $this->getStartingDay();
        $end =  $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ($endWeek === 1)
        {
            $endWeek = intval($end->modify('-7 days')->format('W'))+1;
        }
        $weeks = $endWeek - $startWeek +1;
        if ($weeks < 0)
        {
            $weeks = intval($end->format('W'));
        }

        return $weeks;
    }

    public function inMonth(\DateTimeInterface $date): bool
    {
        return $this->getStartingDay()->format("Y-m") == $date->format("Y-m");
    }

    public function nextMonth()
    {
        $month = $this->month +1;
        $year = $this->year;
        if ($month>12)
        {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    public function prevMonth()
    {
        $month = $this->month -1;
        $year = $this->year;
        if ($month<1)
        {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}