<?php

namespace YourVendor\AdminSession\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use YourVendor\AdminSession\Models\Admin;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = "sample";
        $email = "sample@sample.com";
        $password = $this->secret('Enter the admin password');

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully.');

        return 0;
    }
}
