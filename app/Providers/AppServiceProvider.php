<?php

namespace App\Providers;

use AmazonPaymentServicesSdk\AmazonPaymentServices\Merchant\APSMerchant;
use App\Extensions\CustomDatabaseSessionHandler;
use App\Models\SiteConfig;
use Cookie;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->checkEnvFile();
        $this->CustomDatabaseSessionHandler();
        $this->setAppLocale();
        $this->setConfig();
    }

    /**
     * Create .env file if not exists and generate new app key
     *
     * @return void
     */
    public function checkEnvFile()
    {
        if (!file_exists(base_path('.env'))) {
            @copy(base_path('.env.example'), base_path('.env'));
            Artisan::call('key:generate');
        }
    }

    public function CustomDatabaseSessionHandler() {
        Session::extend('custom-database', function ($app) {
            $table = $app['config']['session.table'];
            $lifetime = $app['config']['session.lifetime'];
            $connection = $app['db']->connection($app['config']['session.connection']);

            return new CustomDatabaseSessionHandler($connection, $table, $lifetime, $app);
        });
    }

    /**
     * set App Locale from 'locale' cookie
     *
     * @return void
     */
    public function setAppLocale()
    {
        if (in_array($locale = Cookie::get('locale', config('app.locale')), ['ar', 'en'])) {
            app()->setLocale($locale);
        }
    }

    /**
     * set App Config
     *
     * @return void
     */

    public function setConfig()
    {
        config()->set('app.direction', app()->getLocale() == "ar" ? 'rtl' : 'ltr');
    }
}
