<?php

namespace Vormkracht10\LaravelSlowQuery;

class Query
{
    public $sql;
    public $bindings;
    public $time;
    public $connectionName;

    public function __construct($sql, $bindings, $time, $connectionName)
    {
        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->time = $time;
        $this->connectionName = $connectionName;
    }
}
