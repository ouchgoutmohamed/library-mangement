<?php
session_start();

interface IMember
{
    public function addDetails(Member $member);
    public function getMember($id);
    public function updateMember(Member $member);
    public function ChangeStatus($memberId,$state);
    public function getAllMember();
    public function getFilteredMembers();
    public function memberLogin($id,$password);
    public function adminLogin($id,$password);
    public function checkMember();
    public function changePassword($id,$password);

}

class MemberService implements IMember{

    public function addDetails(Member $member)
    {
        try {
            $conn = getCon();
            $id=$member->getMemberId();
            $name=$member->getName();
            $email=$member->getEmail();
            $number=$member->getNo();
            $img=$member->getImgUrl();
            $password=$member->getPassword();


            $query = "INSERT INTO `member`(`id`, `name`, `email`, `no`, `state`, `password`, `imgUrl`)
                        VALUES (?,?,?,?,?,?,?)";

            $st = $conn->prepare($query);

            $st->bindValue(1, $id, PDO::PARAM_STR);
            $st->bindValue(2, $name, PDO::PARAM_STR);
            $st->bindValue(3, $email, PDO::PARAM_STR);
            $st->bindValue(4, $number, PDO::PARAM_STR);
            $st->bindValue(5, "active", PDO::PARAM_STR);
            $st->bindValue(6, $password, PDO::PARAM_STR);
            $st->bindValue(7, $img, PDO::PARAM_STR);
            $st->execute();

            return 1;
        }
        catch(SQLiteException $ex){
            return 0;
        }
    }

    public function getMember($id)
    {
        $conn = getCon();
        $query ="SELECT `id`, `name`, `email`, `no`, `state`, `password`, `imgUrl` FROM `member` WHERE `id`=$id";
        $result = $conn->query($query);
        return $result;
    }

    public function updateMember(Member $member)
    {
        try {
            $conn = getCon();
            $id =$member->getMemberId();
            $name=$member->getName();
            $email=$member->getEmail();
            $no=$member->getNo();
            $imgUrl=$member->getImgUrl();

            $query = "UPDATE `member` SET `name`=?,`email`=?,`no`=?,`imgUrl`=? WHERE `id`=$id";

            $st = $conn->prepare($query);
            $st->bindValue(1, $name, PDO::PARAM_STR);
            $st->bindValue(2, $email, PDO::PARAM_STR);
            $st->bindValue(3, $no, PDO::PARAM_STR);
            $st->bindValue(4, $imgUrl, PDO::PARAM_STR);
            $st->execute();

            return 1;
        } catch (SQLiteException $ex) {
            return 0;
        }
    }

    public function ChangeStatus($memberId,$state)
    {
        try {
            $conn = getCon();
            $query = "UPDATE `member` SET `state`=? WHERE `id` = $memberId";

            $st = $conn->prepare($query);
            $st->bindValue(1, $state, PDO::PARAM_STR);
            $st->execute();

            return 1;
        } catch (SQLiteException $ex) {
            return 0;
        }
    }


    public function getAllMember()
    {
        $conn = getCon();
        $query = "SELECT `id`, `name`, `email`, `no`, `state`, `password`, `imgUrl` FROM `member` ORDER BY `state` ASC";
        return $conn->query($query);
    }

    public function getFilteredMembers()
    {
        $conn = getCon();
        $query = $conn->quote($_POST['query'].'%');
        $stmt= "SELECT `id`, `name`, `email`, `no`, `state`, `password`, `imgUrl` FROM `member` WHERE name LIKE $query LIMIT 100";
        return $conn->query($stmt);
    }


    public function memberLogin($id,$password){
        try {
            $conn=getCon();
            $query="SELECT `id`, `state` FROM `member` WHERE `password`=? and `id`=?";
            $st=$conn->prepare($query);
            $st->bindValue(1,$password,PDO::PARAM_STR);
            $st->bindValue(2,$id,PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
            }catch(Exception $e){
            return 0;
            echo'<script> alert( '. $e->getMessage().')</script>';
            }
    }

    public function adminLogin($id,$password){
        try {
            $conn=getCon();
            $query="SELECT `id` FROM `admin` WHERE `password`=? and `id`=?";
            $st=$conn->prepare($query);
            $st->bindValue(1,$password,PDO::PARAM_STR);
            $st->bindValue(2,$id,PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
            } catch(Exception $e) {
            return 0;
            echo'<script> alert( '. $e->getMessage().')</script>';
            }
    }

    public function checkMember()
    {
        $conn = getCon();
        $query = "SELECT `name` FROM member WHERE id='{$_POST['query']}%'";
        return $conn->query($query);
    }

    public function changePassword($id,$password)
    {
        try {
            $conn = getCon();
            $query = "UPDATE `member` SET `password`=? WHERE `id`=$id ";
            $st = $conn->prepare($query);
            $st->bindValue(1, $password, PDO::PARAM_STR);
            $st->execute();

            return 1;
        } catch (SQLiteException $ex) {
            return 0;
        }    }
}
