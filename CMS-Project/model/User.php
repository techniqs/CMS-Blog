<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 07/09/2017
 * Time: 11:40
 */

namespace model;



class User
{
    private $username;
    private $password;
    private $email;
    private $adminrights;

    /**
     * User constructor.
     * @param $username
     * @param $password
     * @param $email
     * @param $adminrights
     */
    public function __construct($username, $password, $email, $adminrights)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->adminrights = $adminrights;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAdminrights()
    {
        return $this->adminrights;
    }


}