<?php

namespace YourVendor\AdminSession\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use YourVendor\AdminSession\Extensions\DatabaseAdminSessionHandler;
use Illuminate\Support\Facades\DB;

class UseAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // リクエストがadminまたはapi/adminパスに一致する場合
        if ($request->is('admin/*') || $request->is('api/admin/*')) {
            
            // セッションドライバをadmin_databaseに拡張
            Session::extend('admin_database', function ($app) {
                $connection = DB::connection(config('session.connection'));

                return new DatabaseAdminSessionHandler(
                    $connection,
                    config('adminsession.table', 'admin_sessions'),
                    config('session.lifetime') * 60,
                    $app
                );
            });

            // セッションドライバをadmin_databaseに設定
            config(['session.driver' => 'admin_database']);
        }

        return $next($request);
    }
}