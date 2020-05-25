<?php
class Day{
    private $days = ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"];
    private $months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    private $year;
    private $month;
    private $day;

    public function __construct(?int $year=null,?int $month=null,?int $day=null)
    {
        if ($month===null || $month < 1 || $month > 12){
            $month = intval(date('m'));
        }
        if ($year===null || $month < 1 || $month > 12){
            $year = intval(date('Y'));
        }
        if ($day===null || $day < 1 || $day > cal_days_in_month(CAL_GREGORIAN, $month, $year)){
            $day = intval(date('d'));
        }
        $jour=new DateTime("{$year}-{$month}-{$day}");
        if((int)$jour->format('N')===6||(int)$jour->format('N')===7){
            $jour->modify('next monday');
            $month=$jour->format('m');
            $year=$jour->format('Y');
            $day=$jour->format('d');
        }
        $this->month=$month;
        $this->year=$year;
        $this->day=$day;
        
    }
    public function nextDay() :Day{
        
        $day=$this->day+1;
        $month=$this->month;
        $year=$this->year;
        $date=new DateTime("{$year}-{$month}-{$day}");
        if($date->format('w')==6){
            $day+=2;
        }
        $lastDay=cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        if($day>$lastDay){
            $day=$day-$lastDay;
            $month=$month+1;
            if ($month>12){
                $month=1;
                $year=$year+1;
            }
        }
        return new Day($year,$month,$day);
    }

    public function previousDay() :Day{
        $day=$this->day-1;
        $month=$this->month;
        $year=$this->year;
        $date=new DateTime("{$year}-{$month}-{$day}");
        if($date->format('w')==0){
            $day-=2;
        }
        if($day<=0){
            $month=$month-1;
            if ($month===0){
                $month=12;
                $year=$year-1;
            }
            $day=cal_days_in_month(CAL_GREGORIAN, $month, $year)+$day;
        }
        return new Day($year,$month,$day);
    }

    public function toString() :string {
        $date=$this->getStart();
        $jour=$this->days[$date->format('w')].' '.$date->format('d').' '.$this->months[$date->format('n')-1].' '.$date->format('Y');
        return $jour;
    }

    public function getDay(){
        return $this->day;
    }
    public function getMonth(){
        return $this->month;
    }
    public function getYear(){
        return $this->year;
    }
    public function getStart(){
        return new DateTime("{$this->year}-{$this->month}-{$this->day} 09:00:00");
    }
    public function pastDay() :bool{
        $date=new DateTime("{$this->year}-{$this->month}-{$this->day}");
        $now=new DateTime();
        if($date->format('Y')<$now->format('Y')){
            return true;
        }elseif($date->format('m')<$now->format('m')){
            return true;
        }elseif($date->format('j')<$now->format('j')){
            return true;
        }else{
            return false;
        }
    }
    public function pastHour(DateTime $heure) :bool{
        $now=new DateTime();
        $now->modify("+3 hours");
        if($heure->format('Y')==$now->format('Y')){
            if($heure->format('m')==$now->format('m')){
                if($heure->format('j')==$now->format('j')){
                    if($heure->format('H')<$now->format('H')){
                        return true;
                    }elseif($heure->format('H')==$now->format('H')){
                        if($heure->format('i')<$now->format('i')){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}