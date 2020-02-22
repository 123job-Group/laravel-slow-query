<?php

namespace Vormkracht10\LaravelSlowQuery\Events;

use Illuminate\Queue\SerializesModels;
use Vormkracht10\LaravelSlowQuery\Query;

class QueryExecutedSlowly
{
    use SerializesModels;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
