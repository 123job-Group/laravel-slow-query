<?php

namespace Vormkracht10\SlowQuery\Events;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Queue\SerializesModels;

class QueryExecutedSlowly
{
    use SerializesModels;

    public $query;

    public function __construct(QueryExecuted $query)
    {
        $this->query = $query;
    }
}
