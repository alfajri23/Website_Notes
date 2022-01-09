<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Facade\FlareClient\View;

use App\Models\Team;
use App\Models\TeamUser;

class AppServiceProvider extends ServiceProvider
{
    public $team;

    public function __construct(){

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        View()->composer('livewire.notes', function ($view) {
            $team = Team::whereIn('id',TeamUser::select('team_id')->where('user_id', auth()->user()->id )->get())->get();
            $view->with('team', $team);
        });


    }
}
