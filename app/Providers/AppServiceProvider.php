<?php

namespace App\Providers;

use App\Models\AdminModels\AdminModule;
use App\Models\AdminModels\Navigation;
use App\Models\AdminModels\FooterNavigation;
use App\Models\AdminModels\SiteSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use App\Console\Commands\ModelMakeCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // fetching all admin menu when some view extendes admin master layout
        //
        view()->composer('admin.layout.master',function($view){
            $moduleOfAdmin = get_anydata('admin_type',auth()->guard('admin')->user()->role,'module');
            $menuList = AdminModule::where([['active','1'],['show_menu','1']])
                        ->whereIn('id',explode(',',$moduleOfAdmin))
                        ->orderBy('priority')
                        ->get();

            $view->with('menuList',$menuList);
        });

        //
        // fetching all frontend menu and footer data when some view extendes master layout
        //
        view()->composer('layout.master',function($view){
            $menuList = Navigation::where('active','1')->orderBy('priority')->get();
            $fmenuList = FooterNavigation::where('active','1')->orderBy('priority')->get();
            $siteData = SiteSettings::find(1);
            $linkData = getLinkData();

            $view->with('menuList',$menuList)->with('fmenuList',$fmenuList)->with('siteData',$siteData)->with('linkData',$linkData);
        });


        //
        // captcha validation rule
        //
        Validator::extend('captcha', function ($attribute, $value, $parameters, $validator) {
            return $value == session('captchaKeyData');
        }, 'Invalid captcha code!');

        //
        // Custom macro for searing in database models
        //
        Builder::macro('search', function ($attributes, string $searchTerm) {
            $searchTerm = str_replace(" ", "%", $searchTerm);
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (array_wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });

            return $this;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });

        $this->app->bind('path.public', function() {
            return base_path().'/html';
        });
    }


}
