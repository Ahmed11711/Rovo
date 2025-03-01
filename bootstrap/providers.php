<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    Froiden\LaravelInstaller\Providers\LaravelInstallerServiceProvider::class,
    App\Providers\CustomConfigProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Macellan\Zip\ZipServiceProvider::class,
    App\Providers\FileStorageCustomConfigProvider::class
];
