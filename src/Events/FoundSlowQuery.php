<?php

namespace Vormkracht10\LaravelSlowQuery\Events;

use Illuminate\Queue\SerializesModels;
use Vormkracht10\LaravelSlowQuery\Query;

class FoundSlowQuery
{
    use SerializesModels;

    public $query;

    public function __construct(Query $query)
    {
        $this->query = $query;
    }
}
