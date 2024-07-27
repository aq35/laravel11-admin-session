<?php

namespace YourVendor\AdminSession\Console\Commands;

use Illuminate\Console\Command;
use YourVendor\AdminSession\Models\Admin;
use YourVendor\AdminSession\Models\AdminSession;

class GetAdminsByName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:admins-by-name {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get admin users by partial name and their session information';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $admins = Admin::where('name', 'LIKE', '%' . $name . '%')->get();

        if ($admins->isEmpty()) {
            $this->error('与えられた名前に部分一致するような運営者は存在しませんでした。');
            return 0;
        }

        foreach ($admins as $admin) {
            $this->info('運営者 詳細:');
            $this->info('氏名: ' . $admin->name);
            $this->info('メールアドレス: ' . $admin->email);

            $sessions = AdminSession::where('admin_id', $admin->id)->get();

            if ($sessions->isNotEmpty()) {
                foreach ($sessions as $session) {
                    $this->info('セッション情報: ');
                    $this->info('IPアドレス: ' . $session->ip_address);
                    $this->info('ユーザーエージェント: ' . $session->user_agent);
                }
                $this->info('ログイン認証済？: Yes');
            } else {
                $this->info('セッション情報: なし');
                $this->info('ログイン認証済？: No');
            }
        }

        return 0;
    }
}
