<?php

namespace App\Date;

use DateTime;

class Week{

    public $days = ["Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"];

    private $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    public $month;
    public $year;
    public $week;
    /**
     * param $week
    *@throws Exception;
    */
    public function __construct(?int $month=null, ?int $year=null, ?int $week=null)
    {   
        $define=false;
        $this->week=$week;
        if($week===null || $week < 1 || $week > 52){
            if ($month===null&&$year===null){
                $this->week = intval(date('W'));
            }else{
                $define=true;
            }
        }
        if ($month===null || $month < 1 || $month > 12){
            $month = intval(date('m'));
        }
        if ($year===null || $month < 1 || $month > 12){
            $year = intval(date('Y'));
        }
        if ($define){
            $mois=new \DateTime("{$year}-{$month}-01");
            $this->week=intVal($mois->format('W'));
        }
        $this->month=$month;
        $this->year=$year;
    }

    public function getStartingDay():\DateTime
    {
        $startmonth = new \DateTime("{$this->year}-{$this->month}-01");
        $numSemaineMois = intVal($this->week-$startmonth->format('W'));
        $startmonth->modify('+' . $numSemaineMois . ' weeks');
        if ($startmonth->format('N')!=1) $startmonth->modify('last monday');
        return $startmonth;
    }

    public function getFinalDay():\DateTime
    {
        $startWeek=$this->getStartingDay();
        return $startWeek->modify('+ 6 days');
    }

    public function toString()
    {
        return $this->months[$this->month - 1] . ' ' . $this->year . ' - Semaine ' . $this->week;
    }
    public function getWeeks()
    {
        $start = $this->getStartingDay();
        if ($start->format('m')==12){
            $end = (clone $start)->modify('+1 month -2 day');
        }else{
            $end = (clone $start)->modify('+1 month -1 day');
        }
        
        
        $weeks = intval($end->format('W')) - intval($start->format('W'));
        if($weeks < 0){
            $weeks=intval($end->format('W'));
        }
        return $weeks;
    }
    public function withinMonth(\DateTime $date)
    {
        $startmonth = new \DateTime("{$this->year}-{$this->month}");
        return $startmonth->format('Y-m') === $date->format('Y-m');
    }

    public function previousWeek(): Week
    {
        $week=$this->week-1;
        $month = $this->month;
        $year=$this->year;
        $changeMois=false;
        if ($this->getStartingDay()->format('m')!=$this->getFinalDay()->format('m')){
            if ($this->month==intVal($this->getFinalDay()->format('m'))){ 
                $week=$this->week;
                $changeMois=true;
            }else{
                $week=$this->week-1;
            }
        }
        if(intVal($this->getStartingDay()->format('d'))==1){
            $changeMois=true;
        }
        if($changeMois){
            $month=$this->month-1;
        }
        if($month < 1){
            $month = 12;
            $year-=1;
            $week=$this->week-1;
        }
        if ($week<1){
            $week=52;
        }
        return new Week($month,$year,$week);
    }

    public function nextWeek(): Week
    {
        $month = $this->month;
        $year=$this->year;
        $week=$this->week+1;
        $changeMois=false;
        $moisTest=$this->getFinalDay()->format('m');
        if($moisTest==1||$moisTest==3||$moisTest==5||$moisTest==7||$moisTest==8||$moisTest==10||$moisTest==12){
            if(intval($this->getFinalDay()->format('d'))==31){
                $changeMois=true;
            }
        }elseif($moisTest==4||$moisTest==6||$moisTest==9||$moisTest==11){
            if(intval($this->getFinalDay()->format('d'))==30){
                $changeMois=true;
            }
        }elseif($moisTest==2){
            if(date('L',$this->getStartingDay()->getTimestamp())){
                $lastday=29;
            }else{
                $lastday=28;
            }
            if(intval($this->getFinalDay()->format('d'))==$lastday){
                $changeMois=true;
            }
        }
        if ($this->getStartingDay()->format('m')!=$this->getFinalDay()->format('m')){
            if ($this->month==intVal($this->getStartingDay()->format('m'))){ 
                $week=$this->week;
                $changeMois=true;
            }else{
                $week=$this->week+1;
            }
        }
            if ($changeMois){
                $month=$month+1;
            }
            if($month > 12){
                $month = 1;
                $year=$this->year+1;
            }
            if ($week>52){
                $month=1;
                $year=$this->year+1;
                $week=1;
            }
            
        
        return new Week($month,$year,$week);
    }
}