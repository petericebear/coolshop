<?php

namespace App\Core\ElasticSearch\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class Ping extends Command
{
    protected $signature = 'elasticsearch:ping';
    protected $description = 'Ping elasticSearch output should be pong.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Client $client)
    {
        $this->info($client->ping() ? 'pong' : 'error');
    }
}
