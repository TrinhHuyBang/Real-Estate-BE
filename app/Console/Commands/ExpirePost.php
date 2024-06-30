<?php

namespace App\Console\Commands;

use App\Events\Notify\PostNotifyEvent;
use Illuminate\Console\Command;
use App\Repos\PostRepo;
use Exception;
use Illuminate\Support\Facades\Log;

class ExpirePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:expired';

    protected $postRepo;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update satus for post when expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PostRepo $postRepo)
    {
        parent::__construct();
        $this->postRepo = $postRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->postRepo->updateExpiredPost();
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
