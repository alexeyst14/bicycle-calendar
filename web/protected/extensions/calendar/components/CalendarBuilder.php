<?php


class CalendarBuilder extends CApplicationComponent implements Iterator
{
    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $numMonth = 1;

    /**
     *
     * @param int $year
     */
    public function __construct($year = null)
    {
        $this->year = is_null($year) ? date('Y') : (int) $year;
    }

    /**
     * Build array for month
     * @param int $numMonth
     * @return SplFixedArray
     */
    public function buildMonth($numMonth) {
        $time = mktime(0, 0, 0, $numMonth, 1, $this->year);
        $offset = date('N', $time) - 1;
        $maxMonthDate = date('t', $time);
        $counter = 0;
        $weeks = new SplFixedArray(6);
        for ($i = 0; $i < count($weeks); $i++) {
            $days = new SplFixedArray(7);
            for ($j = 0; $j < count($days); $j++) {
                if ($offset > $j && $i == 0 || $counter >= $maxMonthDate) {
                    $days[$j] = null;
                    continue;
                }
                $days[$j] = ++$counter;
            }
            $weeks[$i] = $days;
        }
        return $weeks;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->buildMonth($this->numMonth);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->numMonth++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->numMonth;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->numMonth <= 12;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->numMonth = 1;
    }

    public static function getDaysNames()
    {
        return array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
    }

    public static function getMonthsNames()
    {
        return array(
            'Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'
        );
    }

}
