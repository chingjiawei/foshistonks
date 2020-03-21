<?php

class Project{
    private $projectid;
    private $employerid;
    private $title;
    private $risk;
    private $payout;
    private $loss;
    private $employees;
    private $timer;
    private $duration;
    private $status;
    private $employeeid;
    private $salary;
    
    public function __construct($projectid='', $employerid='', $title='', $risk='', $payout='', $loss='', $employees='', $timer='', $duration='', $status='active', $employeeid='', $salary=0){
        $this->projectid = $projectid;
        $this->employerid = $employerid;
        $this->title = $title;
        $this->risk = $risk;
        $this->payout = $payout;
        $this->loss = $loss;
        $this->employees = $employees;
        $this->timer = $timer;
        $this->duration = $duration;
        $this->status = $status;
        $this->employeeid = $employeeid;
        $this->salay = $salary;
    }

}




?>