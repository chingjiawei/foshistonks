<?php
class ProjectDAO{
    public function addProject($employerid, $title, $risk, $payout, $loss, $employees, $timer, $duration){
        $sql = "INSERT INTO project (employerid, title, risk, payout, loss, employees, timer, duration, status, employeeid, salary) VALUES (:employerid, :title, :risk, :payout, :loss, :employees, :timer, :duration, 'active', null, 0)";
        
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employerid', $employer, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':risk', $risk, PDO::PARAM_STR);
        $stmt->bindParam(':payout', $payout, PDO::PARAM_STR);
        $stmt->bindParam(':loss', $loss, PDO::PARAM_STR);
        $stmt->bindParam(':employees', $employees, PDO::PARAM_INT);
        $stmt->bindParam(':timer', $timer, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $druation, PDO::PARAM_STR);

        $result = [];
        if ($stmt->execute()) {
            //Project ID auto generated, so we need to get it
            $sql1 = "SELECT * FROM project WHERE employerid = :employerid and status='active'";
            $stmt1 = $conn->prepare($sql1);
            $stmt1->bindParam(':employerid', $employer, PDO::PARAM_STR);
            $stmt1->execute();
            //Return Project Object
            while ($row = $stmt1->fetch()){
                $result[] = new Project($row['projectid'], $row['employerid'], $row['title'], $row['risk'], $row['payout'], $row['loss'], $row['employees'], $row['timer'], $row['status'], $row['salary']);
            }
        }
        return $result;
    }

    public function checkEmployerProject($employerid){
        $sql = "SELECT * FROM project WHERE employerid = :employerid and status = 'active'";
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employerid', $employerid, PDO::PARAM_STR);
        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch()){
            $result[] = new Project($row['projectid'], $row['employerid'], $row['title'], $row['risk'], $row['payout'], $row['loss'], $row['employees'], $row['timer'], $row['status'], $row['salary']);
        }
        return $result;
    }

    public function getEmployerProject($employerid){
        $sql = "SELECT * FROM project WHERE employerid = :employerid";
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employerid', $employerid, PDO::PARAM_STR);
        $stmt->bindParam(':employeeid', $employerid, PDO::PARAM_STR);
        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch()){
            $result[] = new Project($row['projectid'], $row['employerid'], $row['title'], $row['risk'], $row['payout'], $row['loss'], $row['employees'], $row['timer'], $row['status'], $row['salary']);
        }
        return $result;
    }

    public function getEmployeeProject($employeeid){
        $sql = "SELECT * FROM project WHERE employeeid = :employeeid";
        $connMgr = new ConnectionManager();      
        $conn = $connMgr->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employeeid', $employeeid, PDO::PARAM_STR);
        $stmt->execute();
        $result = [];
        while ($row = $stmt->fetch()){
            $result[] = new Project($row['projectid'], $row['employerid'], $row['title'], $row['risk'], $row['payout'], $row['loss'], $row['employees'], $row['timer'], $row['status'], $row['salary']);
        }
        return $result;

    }


}




















?>