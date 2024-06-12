<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Traits\HasPermission;
use Illuminate\Console\Command;

class CheckPermission extends Command
{
    use HasPermission;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:check-permission {admin_id} {permission_id}';

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
        $admin_id = $this->argument('admin_id');
        $permission_id = $this->argument('permission_id');
        $admin = Admin::where('id', $admin_id)->first();
        $permission = $this->checkPermission($admin, $permission_id) ? 'true' : 'false';
        $this->info($permission);
    }
}
