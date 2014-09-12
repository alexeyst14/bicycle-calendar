<?php

Yii::import('calendar.components.*');

class Calendar extends CWidget
{
    public function run()
    {
        parent::run();
        
        $months = CalendarBuilder::getMonthsNames();
        $html = "";
        foreach (new CalendarBuilder() as $k => $month) {
            $html .= '<table class="month">';
            $html .= '<tr align="center" class="monthname">
                <td colspan="5">' . $months[$k-1] . '</td>
                <td colspan="2">' . 
                    CHtml::textField("month[$k]", "", array(
                        'class' => 'monthInput',
                        'readonly' => 'readonly',
                    )) .
                '</td></tr>';
            $html .= '<tr align="right" class="daynames">';
            foreach (CalendarBuilder::getDaysNames() as $name) {
                $html .= '<td>' . $name . '</td>';
            }
            $html .= '</tr>';
            foreach ($month as $weeks) {
                $html .= '<tr align="right" class="date">';
                foreach ($weeks as $day) {
                    $date = is_null($day) ? '&nbsp;' : $day;
                    $html .= '<td>' . $date . '</td>';
                }
                $html .= '</tr>';
                $html .= '<tr class="form">';
                foreach ($weeks as $day) {
                    $name = "dist[$k][$day]";
                    $field = is_null($day) ? '&nbsp;' : CHtml::textField($name, "", array(
                        'class' => 'distInput',
                        'readonly' => Yii::app()->user->isGuest
                    ));
                    $html .= '<td>' . $field . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= "</table>\n";
        }
        echo $html;
    }
}