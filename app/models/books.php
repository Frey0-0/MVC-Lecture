<?php

namespace Model;

class Books
{
    public static function requestBook($name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT quantity FROM books WHERE status IS NULL AND name=? ");
        $query->execute([$name]);
        $result =  $query->fetch();
        return $result;
    }

    public static function requestBookInsert($name,$username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("INSERT INTO books(name,username,quantity,date,month,year,status) VALUES (?,?,1,null,null,null,0)");
        $query->execute([$name, $username]);
    }

    public static function requestBookUpdate($quantity, $name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET quantity=? WHERE status IS NULL AND name=?");
        $query->execute([($quantity - 1), $name]);
    }

    public static function requestBookDelete($name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("DELETE FROM books WHERE status IS NULL AND name=?");
        $query->execute([$name]);
    }

    public static function returnBook($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET status=-1 WHERE name=? AND username=?");
        $query->execute([$name, $username]);
    }
    
    public static function issuedBooks($username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name FROM books WHERE status=1 AND username=?");
        $query ->execute([$username]);
        $result =  $query ->fetchAll();
        return $result;
    }

    public static function availableBooks()
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,quantity FROM books WHERE status IS NULL");
        $query ->execute();
        $result =  $query ->fetchAll();
        return $result;
    }

    public static function requestedBooks($username)
    {
        $db = \DB::get_instance();
        $query  = $db->prepare("SELECT name FROM books WHERE status=0 AND username =?");
        $query ->execute([$username]);
        $result =  $query ->fetchAll();
        return $result;
    }

    public static function rejectedRequests($username)
    {
        $db = \DB::get_instance();
        $query  = $db->prepare("SELECT name FROM books WHERE status=2 AND username =?");
        $query ->execute([$username]);
        $result =  $query ->fetchAll();
        return $result;
    }
    public static function rejectedRequestsDelete($username)
    {
        $db = \DB::get_instance();
        $query  = $db->prepare("DELETE FROM books WHERE status=2 AND username =?");
        $query ->execute([$username]);
    }

    public static function addBook($name, $quantity)
    {
        $db = \DB::get_instance();
        $query  = $db->prepare("INSERT INTO  books VALUES(?,NULL,?,NULL,NULL,NULL,NULL)");
        $query ->execute([$name, $quantity]);
    }

    public static function removeBook($name, $quantity)
    {
        $db = \DB::get_instance();
        $query  = $db->prepare("SELECT name,quantity FROM books WHERE status IS NULL AND name=?");
        $query ->execute([$name]);
        $result =  $query ->fetchAll();
        return $result;
    }

    public static function removeBookUpdate($quantity, $name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET quantity=? WHERE status IS NULL AND name =?");
        $query->execute([$quantity, $name]);
    }

    public static function removeBookDelete($name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("DELETE FROM books WHERE status IS NULL AND name=?");
        $query->execute([$name]);
    }

    public static function approved($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("INSERT INTO books VALUES(?,?,1,?,?,?,1)");
        $query->execute([$name, $username, date("d"), date("m"), date("Y")]);
    }

    public static function approvedDelete($name,$username){
        $db = \DB::get_instance();
        $query = $db->prepare("DELETE FROM books WHERE name=? AND username=? AND status=0 ");
        $query->execute([$name, $username]);
    }

    public static function disapproved($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,quantity FROM books WHERE status IS NULL AND name=?");
        $query->execute([$name]);
        $result = $query->fetchAll();
        return $result;
    }

    public static function disapprovedUpdate($quantity, $name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET quantity=? WHERE status IS NULL AND name=?");
        $query->execute([$quantity, $name]);
    }

    public static function disapprovedInsert($name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("INSERT INTO books VALUES(?,NULL,1,NULL,NULL,NULL,NULL)");
        $query->execute([$name]);
    }

    public static function disapprovedUpdate2($username, $name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET status=2 WHERE username=? AND name=? AND status=0");
        $query->execute([$username, $name]);
    }

    public static function approvedReturn($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,quantity FROM books where status IS NULL AND name=?");
        $query->execute([$name]);
        $result = $query->fetchAll();
        return $result;
    }

    public static function approvedReturnInsert($name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("INSERT INTO books VALUES(?,NULL,1,NULL,NULL,NULL,NULL)");
        $query->execute([$name]);
    }
    public static function approvedReturnUpdate($quantity, $name)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET quantity=? WHERE status IS NULL and name=?");
        $query->execute([$quantity, $name]);
    }

    public static function approvedReturnDelete($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("DELETE FROM books WHERE status=-1 AND name=? AND username=?");
        $query->execute([$name, $username]);
    }

    public static function disapprovedReturn($name, $username)
    {
        $db = \DB::get_instance();
        $query = $db->prepare("UPDATE books SET status=1 WHERE username=? AND name=? AND status=-1");
        $query->execute([$username, $name]);
    }

    public static function unavailableBooks()
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,username FROM books WHERE status=1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function checkout()
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,username FROM books WHERE status=0");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public static function checkin()
    {
        $db = \DB::get_instance();
        $query = $db->prepare("SELECT name,username,date,month,year FROM books WHERE status=-1");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
