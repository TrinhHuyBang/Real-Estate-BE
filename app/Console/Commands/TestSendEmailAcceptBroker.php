<?php

namespace App\Console\Commands;

use App\Jobs\sendMailForAcceptBrokerJob;
use Illuminate\Console\Command;

class TestSendEmailAcceptBroker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test-accept-broker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        sendMailForAcceptBrokerJob::dispatch('Huy Bang', 'huybang.trinh@gmail.com', '0917217261', 'bangnhang12042001@gmail.com', true)->onQueue('email');
        sendMailForAcceptBrokerJob::dispatch('Huy Bang', 'huybang.trinh@gmail.com', '0917217261', 'bangnhang12042001@gmail.com', false)->onQueue('email');
        return true;
    }
}
