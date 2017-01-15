<?php
date_default_timezone_set("Europe/Rome");
require("phplib.php");

class Calendar{
  /********************* ATTRIBUTES ********************/  
  public $currentYear=0;
  public $currentMonth=0;
  public $currentWeek=0;
  public $currentDay=0;
  public $currentDate=null;
  public $weeksInMonth=0;
  public $daysInMonth=0;
  public $todayYear=null;
  public $todayMonth=null;
  public $todayWeek=null;
  public $todayDay=null;
  public $mobile=false;

  /**
   * Constructor
   */
  public function __construct(){
    $this->mobile = isMobile();
    $this->setCurrents();
  }
  
  /********************* PUBLIC **********************/

  /**
  * check if nowork day
   * @param $i string
   * @param $d string
   * @param $m string
   * @return true|false
  */
  public function nowork_day($i,$d,$m=''){
    $this->setCurrents();
    $day_label = $d;
    $day_num = $m == '' ?  sprintf('%02d',$i)."-".$this->currentMonth :  sprintf('%02d',$i)."-".$m;
    $nowork = array("SAB","DOM","01-01","24-12","25-12","31-12");
    if(in_array($day_label, $nowork) || in_array($day_num, $nowork)){
      return true;
    }
    return false;
  }

  /**
  * set current yy-mm-dd
  */
  public function setCurrents(){
    $year  = null;
    $month = null;
    $week = null;
    $day = null;
    if(null==$year&&isset($_GET['year'])){
      $year = $_GET['year'];
    }else if(null==$year){
      $year = date("Y",time());
    }
    if(null==$month&&isset($_GET['month'])){
      $month = $_GET['month'];
    }else if(null==$month){
      $month = date("m",time());
    }
    if(null==$week&&isset($_GET['week'])){
      $week = $_GET['week'];
    }else if(null==$week){
      $week = date("W",time());
    }
    if(null==$day&&isset($_GET['day'])){
      $day = $_GET['day'];
    }else if(null==$day){
      $day = date("d",time());
    }
    $this->currentYear=$year;
    $this->currentMonth=$month;
    $this->currentWeek=$week;
    $this->currentDay=$day;
    $this->todayYear=date("Y");
    $this->todayMonth=date("m");
    $this->todayWeek=date("W");
    $this->todayDay=date("d");
    $this->currentDate=date("".$this->currentYear."/".$this->currentMonth."/".$this->currentWeek."/".$this->currentDay."");
    $this->weeksInMonth=$this->_weeksInMonth($month,$year);
    $this->daysInMonth=$this->_daysInMonth($month,$year);
  }

  /**
  * calculate number of weeks in a given month and year
   * @param $month string
   * @param $year string
   * @return int
  */
  public function _weeksInMonth($month=null,$year=null){
    if( null==($year) ) {
      $year =  date("Y",time());
    }
    if(null==($month)) {
      $month = date("m",time());
    }
    // find number of days in this month
    $daysInMonths = $this->_daysInMonth($month,$year);
    $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
    $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
    $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
    if($monthEndingDay<$monthStartDay){
      $numOfweeks++;
    }
    return $numOfweeks;
  }

  /**
  * calculate number of days in a given month and year
   * @param $month string
   * @param $year string
   * @return int
  */
  public function _daysInMonth($month=null,$year=null){
    if(null==($year))
      $year =  date("Y",time()); 
    if(null==($month))
      $month = date("m",time());
    return date('t',strtotime($year.'-'.$month.'-01'));
  }

  /**
  * convert days EN-->IT
   * @param $str string
   * @return string
  */
  public function days_toIta($str){
    $string = $str;
    $string = str_replace('Mon', 'Lun', $string);
    $string = str_replace('Tue', 'Mar', $string);
    $string = str_replace('Wed', 'Mer', $string);
    $string = str_replace('Thu', 'Gio', $string);
    $string = str_replace('Fri', 'Ven', $string);
    $string = str_replace('Sat', 'Sab', $string);
    $string = str_replace('Sun', 'Dom', $string);
    $string = str_replace('Monday', 'Lunedì', $string);
    $string = str_replace('Tuesday', 'Martedì', $string);
    $string = str_replace('Wednesday', 'Mercoledì', $string);
    $string = str_replace('Thursday', 'Giovedì', $string);
    $string = str_replace('Friday', 'Venerdì', $string);
    $string = str_replace('Saturday', 'Sabato', $string);
    $string = str_replace('Sunday', 'Domenica', $string);
    return strtoupper($string);
  }

  /**
  * convert months EN-->IT
   * @param $str string
   * @return string
  */
  public function month_toIta($str){
    $string = $str;
    $string = str_replace('Jan', 'Gen', $string);
    $string = str_replace('Feb', 'Feb', $string);
    $string = str_replace('Mar', 'Mar', $string);
    $string = str_replace('Apr', 'Apr', $string);
    $string = str_replace('May', 'Mag', $string);
    $string = str_replace('Jun', 'Giu', $string);
    $string = str_replace('Jul', 'Lug', $string);
    $string = str_replace('Aug', 'Ago', $string);
    $string = str_replace('Sep', 'Set', $string);
    $string = str_replace('Oct', 'Ott', $string);
    $string = str_replace('Nov', 'Nov', $string);
    $string = str_replace('Dec', 'Dic', $string);
    $string = str_replace('January', 'Gennaio', $string);
    $string = str_replace('February', 'Febbraio', $string);
    $string = str_replace('March', 'Marzo', $string);
    $string = str_replace('April', 'Aprile', $string);
    $string = str_replace('May', 'Maggio', $string);
    $string = str_replace('June', 'Giugno', $string);
    $string = str_replace('July', 'Luglio', $string);
    $string = str_replace('August', 'Agosto', $string);
    $string = str_replace('September', 'Settembre', $string);
    $string = str_replace('October', 'Ottobre', $string);
    $string = str_replace('November', 'Novembre', $string);
    $string = str_replace('December', 'Dicembre', $string);
    return strtoupper($string);
  }

  /**
  * return true if date parameter correspond with today
   * @param $y string
   * @param $m string
   * @param $w string
   * @param $d string
   * @return true|false
  */
  public function checkIsToday($y,$m,$w,$d){
    $day = $y.'/'.$m.'/'.$w.'/'.$d;
    $today = date('Y/m/W/d');
    return $day==$today;
  }

  /**
   * return true if date parameter correspond with today
   * @param $var string
   * @return string
   */
  public function getFullTipo($var){
    $res = '';
    switch ($var) {
      case 'att_int':
        $res = 'Interventi';
        break;
    }
    return $res;
  }

  /**
   * return true if date parameter correspond with today
   * @param $var string
   * @return string
   */
  public function getUpperFullTipo($var){
    $res = '';
    switch ($var) {
      case 'att_int':
        $res = 'INTERVENTI';
        break;
    }
    return $res;
  }

  /**
   * return true if date parameter correspond with today
   * @param $var string
   * @return string
   */
  public function getKindFullTipo($var){
    $res = '';
    switch ($var) {
      case 'att_int':
        $res = 'Interventi';
        break;
    }
    return $res;
  }

  /**
   * footer
   * @return string
   */
  public function showFooter(){
    $res = '<ul class="links" style="color:black">'.
      '<li>&copy; .......</li>'.
      '<li>Author : <a href="http://4uservice.it/" target="_blank" style="color:black">4U Service</a></li>'.
    '</ul>';
    return $res;
  }
}