<?php

class Connection
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $port;
    private $link;

    function __construct()
    {
        $this->setConnect();
        $this->connect();
    }



