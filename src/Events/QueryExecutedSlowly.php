<?php

namespace Vormkracht10\SlowQuery\Events;

use Illuminate\Queue\SerializesModels;
use Vormkracht10\SlowQuery\Query;

class QueryExecutedSlowly
{
    use SerializesModels;

    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
