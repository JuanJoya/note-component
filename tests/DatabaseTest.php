<?php

use Note\Infrastructure\Database;

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    public $db;

    function __construct()
    {
        $this->db = new Database;
    }

    /*function test_affected_rows_from_query()
    {
        $result = $this->db->executeSingleQuery("INSERT INTO users (email, password) VALUES ('1', 'adsadad'), ('2', 'ASDASD')");
        var_dump($result);
    }*/

    function test_get_results_from_query()
    {
        $result = $this->db->getResultsFromQuery("SELECT * FROM notes LIMIT 1");
        var_dump($result);
    }

    function test_get_results_from_query_fail()
    {
        $this->setExpectedException(RuntimeException::class);
        $this->db->getResultsFromQuery("SELECT * FROM randomTable");
    }
}
