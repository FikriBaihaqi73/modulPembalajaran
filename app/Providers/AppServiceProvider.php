<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
        // Register the storeOnCloudinary macro for UploadedFile
        UploadedFile::macro('storeOnCloudinary', function ($folder = null, $options = []) {
            return Storage::disk('cloudinary')->putFile($folder, $this, $options);
        });
    }
}
