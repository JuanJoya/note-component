<?php

use Note\Infrastructure\Database;

class DatabaseTest extends PHPUnit_Framework_TestCase
{
    function test_get_results_from_query_fail()
    {
        $this->setExpectedException(RuntimeException::class);
        $db = new Database();
        $db->query = "SELECT * FROM randomTable";
        $db->getResultsFromQuery();
    }
}
