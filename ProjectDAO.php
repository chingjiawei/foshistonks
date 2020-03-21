<?php
class ProjectDAO{
    public function addProject(){
        $sql = "INSERT INTO project (projectid, employerid, title, risk, payout, loss, employees, timer, duration, status, employeeid, status) VALUES (:projectid, :employerid, :title, :risk, :payout, :loss, :employees, :timer, :duration, 'active', :employeeid, 0)";
        
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':projectid', $projectid, PDO::PARAM_STR);
        $stmt->bindParam(':employerid', $employer, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':risk', $risk, PDO::PARAM_STR);
        $stmt->bindParam(':payoff', $payoff, PDO::PARAM_INT);
        $isAddOK = False;
        if ($stmt->execute()) {
            $isAddOK = True;
        }
        return $isAddOK;
    }

    public function getProject(){
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();

        $stmt = $conn->prepare($sql);
    }


}




















?>