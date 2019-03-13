<?php

namespace PowerMs\Providers;


use Illuminate\Support\ServiceProvider;
use View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('MyLibs/Helpers/MyHelper.php');

        $sql="select COUNT(id) As total_users from users";
        $result=\DB::select($sql);
        foreach ($result as $value) {
            $r=$value->total_users;
        }
        View::share('users_total',$r);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
