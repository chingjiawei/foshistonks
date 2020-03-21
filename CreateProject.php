<?php

    //Composite Microservice - need to do one for includeProject (employee add themselves to project)

    //Employerid and Risk to be changed in the future
    //if isset($_POST['risk'])
    $employerid = 'foshi'; //$_POST['employerid']
    $risk = 'L'; //L M or H.  $_POST['risk']

    $titles = ["Clean Toilet", "Go Fishing", "Rap with Donkey Kong", "Do absolutely everything"]
    
    $projectdao = new ProjectDAO();
    if ($projectdao->getEmployerProject != []){
        $result = [
            "status" => "error",
            "message" => "Already have active project!"
        ];
        return $result;
    }

    //Here I need to fetch stonks of the user with Account Microservice
    $stonks = 1000
    $datetime = new DateTime();
    if ($risk == 'L'){
        $payoff = round($stonks * rand(5, 10) / 100) ;
        $risk = round($payoff * 0.25);
        $employees = rand(1, 10);
    }
    else if ($risk == 'M'){
        $payoff = round($stonks * rand(11, 25) / 100) ;
        $risk = round($payoff * 0.5);
        $employees = rand(11, 25);
    }
    else{
        $payoff = round($stonks * rand(26, 50) / 100) ;
        $risk = $payoff;
        $employees = rand(26, 50);
    }
    $length = rand(60, 120);
    $title = $titles[rand(0, count($title) - 1)];
    $timer = $datetime->modify("+$length minutes")
    $duration = rand(60, 300);

    $outcome = addProject($employerid, $title, $risk, $payout, $loss, $employees, $timer, $duration);
    if ($outcome == []){
        $result = [
            "status" => "error",
            "message" => "Project can't be created at this time."
        ];
    }
    else{
        $result = [
            "status" => "success",
            "message" =?
        ]
    }




?>