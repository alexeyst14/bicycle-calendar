<?php
/* @var $this SiteController */
/* @var $year int */

$this->pageTitle=Yii::app()->name;
$this->widget('ext.widgets.loading.LoadingWidget');

?>

<h1 class="calendar">ГОД&nbsp;&nbsp;<?php echo $year; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<span id="year-dist"></span></h1>

<div id="calendar">
    <?php $this->widget('calendar.widgets.Calendar', array()); ?>
</div>

<!--
<table class="params">
    <tr><td>Всего байкеров:</td><td></td></tr>
    <tr><td>Пройдено километров в этом году:</td><td></td></tr>
    <tr><td>Пройдено километров в этом месяце:</td><td></td></tr>
</table>
-->
