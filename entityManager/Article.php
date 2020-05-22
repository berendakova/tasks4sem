<?php
require_once 'DataMapper.php';

class Article extends DataMapper
{
    protected $dbName = "art";
    protected $userName = "root";
    protected $password = "password";
    protected $pk =  "id";
}