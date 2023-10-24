<?php

namespace classes;
use PDOException;

class People {
    private $nic;
    private $name;
    private $address;
    private $contact;
    private $email;
    
    private $con;
    
    public function __construct($nic, $name, $address, $contact, $email){
        $this->nic = $nic;
        $this->name = $name;
        $this->address = $address;
        $this->contact = $contact;
        $this->email = $email;
    }

    // GETTERS
    public function getNIC(){
        return $this->nic;
    }

    public function getName(){
        return $this->name;
    }

    // SETTERS
    public function setCon($con){
        $this->con = $con;
    }

    public function addPerson(){
        try{
            $query1 = "SELECT nic FROM people WHERE nic=?";
            $pstmt1 = $this->con->prepare($query1);
            $pstmt1->bindValue(1, $this->nic);
            $pstmt1->execute();
            $rows = $pstmt1->rowCount();

            if($rows == 0){
                $query2 = "INSERT INTO people(nic, name, address, contact, email) VALUES(?, ?, ?, ?, ?)";
                try{
                    $pstmt2 = $this->con->prepare($query2);
                    $pstmt2->bindValue(1, $this->nic);
                    $pstmt2->bindValue(2, $this->name);
                    $pstmt2->bindValue(3, $this->address);
                    $pstmt2->bindValue(4, $this->contact);
                    $pstmt2->bindValue(5, $this->email);
                    $a = $pstmt2->execute();

                    if($a>0){
                        return true;
                    }
                    else{
                        return false;
                        die("Record insertion failed");
                    }
                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function updatePerson(){
        $query = "UPDATE people SET name=?, address=?, contact=?, email=? WHERE nic=?";
        try{
            $pstmt = $this->con->prepare($query);
            $pstmt->bindValue(1, $this->name);
            $pstmt->bindValue(2, $this->address);
            $pstmt->bindValue(3, $this->contact);
            $pstmt->bindValue(4, $this->email);
            $pstmt->bindValue(5, $this->nic);

            $a = $pstmt->execute();
            if($a > 0){
                return true;
            }
            else{
                return false;
                die("Update Failed: People Table <br>");
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}