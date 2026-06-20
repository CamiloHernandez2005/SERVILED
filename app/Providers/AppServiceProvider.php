<?php

namespace App\Providers;

use Google\Client;
use Google\Service\Drive;
use Masbug\Flysystem\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('greater_than_zero', function ($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });
        Paginator::useBootstrap();
        // $this->loadGoogle();
    }

    // public function loadGoogle(): void
    // {
    //     try {
    //     Storage::extend('google', function($app, $config) {
    //         $options = [];

    //         if (!empty($config['teamDriveId'] ?? null)) {
    //             $options['teamDriveId'] = $config['teamDriveId'];
    //         }

    //         if (!empty($config['sharedFolderId'] ?? null)) {
    //             $options['sharedFolderId'] = $config['sharedFolderId'];
    //         }

    //         $client = new Client();
    //         $client->setClientId($config['clientId']);
    //         $client->setClientSecret($config['clientSecret']);
    //         $client->refreshToken($config['refreshToken']);
            
    //         $service = new Drive($client);
    //         $adapter = new GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
    //         $driver = new Filesystem($adapter);

    //         return new FilesystemAdapter($driver, $adapter);
    //     });
    // } catch(\Exception $e) {
    //     // your exception handling logic
    // }
    //}
    // // ...

}

