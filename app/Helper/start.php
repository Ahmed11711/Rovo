<?php

use App\Models\EmailSetting;
use App\Models\GlobalSetting;
use App\Models\LanguageSetting;
use App\Helper\Files;
use App\Models\Package;
use App\Models\PaymentGatewayCredential;
use App\Models\PusherSetting;
use App\Models\Restaurant;
use App\Models\StorageSetting;
use App\Models\SuperadminPaymentGateway;
use App\Models\GlobalCurrency;
use App\Models\Currency;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

if (!function_exists('user')) {

    /**
     * Return current logged-in user
     */
    function user()
    {
        if (session()->has('user')) {
            return session('user');
        }


        session(['user' => auth()->user()]);

        return session('user');
    }
}

function customer()
{
    if (session()->has('customer')) {
        return session('customer');
    }

    return null;
}

function restaurant()
{
    if (session()->has('restaurant')) {
        return session('restaurant');
    }

    if (user()) {
        if (user()->restaurant_id) {
            session(['restaurant' => Restaurant::find(user()->restaurant_id)]);
            return session('restaurant');
        }
    }

    // session(['restaurant' => Restaurant::first()]); // Used in Non-saas

    // return session('restaurant');  // Used in Non-saas
    return false;  // Used in Saas

}

function shop($hash = null)
{
    if (session()->has('shop')) {
        return session('shop');
    }

    if (!is_null($hash)) {
        session(['shop' => Restaurant::where('hash', $hash)->first()]);
        return session('shop');
    }

    return false;  // Used in Saas

}

function branch()
{
    if (session()->has('branch')) {
        return session('branch');
    }

    if (restaurant()) {
        session(['branch' => user()->branch ?? restaurant()->branches->first()]);
        return session('branch');
    }

    return false;
}

function shop_branch()
{
    if (session()->has('shop_branch')) {
        return session('shop_branch');
    }

    if (shop()) {
        session(['shop_branch' => shop()->branches->first()]);
        return session('shop_branch');
    }

    return false;
}

function currency()
{
    if (session()->has('currency')) {
        return session('currency');
    }

    if (restaurant()) {
        session(['currency' => restaurant()->currency->currency_symbol]);

        return session('currency');
    }

    return false;
}

function timezone()
{
    if (session()->has('timezone')) {
        return session('timezone');
    }

    if (restaurant()) {
        session(['timezone' => restaurant()->timezone]);

        return session('timezone');
    }

    return false;
}

function paymentGateway()
{
    if (session()->has('paymentGateway')) {
        return session('paymentGateway');
    }

    if (shop()) {
        $payment = PaymentGatewayCredential::where('restaurant_id', shop()->id)->first();

        session(['paymentGateway' => $payment]);

        return session('paymentGateway');
    }

    return false;
}

if (!function_exists('check_migrate_status')) {

    // @codingStandardsIgnoreLine
    function check_migrate_status()
    {

        if (!session()->has('check_migrate_status')) {

            $status = Artisan::call('migrate:check');

            if ($status && !request()->ajax()) {
                Artisan::call('migrate', ['--force' => true, '--schema-path' => 'do not run schema path']); // Migrate database
                Artisan::call('optimize:clear');
            }

            session(['check_migrate_status' => 'Good']);
        }

        return session('check_migrate_status');
    }
}

if (!function_exists('role_permissions')) {

    function role_permissions()
    {
        if (session()->has('role_permissions')) {
            return session('role_permissions');
        }

        $roleID = user()->roles->first()->id;
        $permissions = Role::where('id', $roleID)->first()->permissions->pluck('name')->toArray();

        return session(['role_permissions' => $permissions]);
    }
}

if (!function_exists('user_can')) {

    function user_can($permission)
    {
        if (is_null(role_permissions())) {
            $rolePermissions = [];
        } else {
            $rolePermissions = role_permissions();
        }

        return in_array($permission, $rolePermissions);
    }
}

if (!function_exists('restaurant_modules')) {
    function restaurant_modules(): array
    {
        $restaurant = restaurant();

        if (!$restaurant) {
            return [];
        }

        $cacheKey = 'restaurant_modules_' . $restaurant->id;
        if (cache()->has($cacheKey)) {
            return cache($cacheKey);
        }

        $user = user();
        if (is_null($user->restaurant_id) && is_null($user->branch_id)) {
            return [];
        }

        $restaurant = Restaurant::with('package.modules')->find($restaurant->id);
        session(['restaurant' => $restaurant]);

        $package = $restaurant->package;

        $packageModules = $package->modules->pluck('name')->toArray();
        $additionalFeatures = json_decode($package->additional_features ?? '[]', true);

        $allModules = array_unique(array_merge($packageModules, $additionalFeatures));

        cache([$cacheKey => $allModules]);

        return cache($cacheKey);
    }
}


if (!function_exists('global_setting')) {

    // @codingStandardsIgnoreLine
    function global_setting()
    {

        if (cache()->has('global_setting')) {
            return cache('global_setting');
        }

        cache(['global_setting' => GlobalSetting::first()]);

        return cache('global_setting');
    }
}

if (!function_exists('restaurantOrGlobalSetting')) {

    function restaurantOrGlobalSetting()
    {
        if (user()) {

            if (user()->restaurant_id) {
                return restaurant();
            }
        }

        return global_setting();
    }
}

if (!function_exists('branches')) {

    function branches()
    {

        if (session()->has('branches')) {
            return session('branches');
        }

        if (restaurant()) {
            return session(['branches' => restaurant()->branches]);
        }

        return false;
    }
}

if (!function_exists('isRtl')) {

    function isRtl()
    {

        if (session()->has('isRtl')) {
            return session('isRtl');
        }

        if (user()) {
            $language = LanguageSetting::where('language_code', auth()->user()->locale)->first();
            $isRtl = ($language->is_rtl == 1);
            session(['isRtl' => $isRtl]);
        }

        return false;
    }
}

if (!function_exists('languages')) {

    function languages()
    {

        if (cache()->has('languages')) {
            return cache('languages');
        }

        $languages = LanguageSetting::where('active', 1)->get();
        cache(['languages' => $languages]);

        return cache('languages');
    }
}

if (!function_exists('asset_url_local_s3')) {

    // @codingStandardsIgnoreLine
    function asset_url_local_s3($path)
    {
        if (in_array(config('filesystems.default'), StorageSetting::S3_COMPATIBLE_STORAGE)) {
            // Check if the URL is already cached
            if (Cache::has(config('filesystems.default') . '-' . $path)) {
                $temporaryUrl = Cache::get(config('filesystems.default') . '-' . $path);
            } else {
                // Generate a new temporary URL and cache it
                $temporaryUrl = Storage::disk(config('filesystems.default'))->temporaryUrl($path, now()->addMinutes(StorageSetting::HASH_TEMP_FILE_TIME));
                Cache::put(config('filesystems.default') . '-' . $path, $temporaryUrl, StorageSetting::HASH_TEMP_FILE_TIME * 60);
            }

            return $temporaryUrl;
        }

        $path = Files::UPLOAD_FOLDER . '/' . $path;
        $storageUrl = $path;

        if (!Str::startsWith($storageUrl, 'http')) {
            return url($storageUrl);
        }

        return $storageUrl;
    }
}

if (!function_exists('download_local_s3')) {

    // @codingStandardsIgnoreLine
    function download_local_s3($file, $path)
    {

        if (in_array(config('filesystems.default'), StorageSetting::S3_COMPATIBLE_STORAGE)) {
            return Storage::disk(config('filesystems.default'))->download($path, basename($file->filename));
        }

        $path = Files::UPLOAD_FOLDER . '/' . $path;
        $ext = pathinfo($file->filename, PATHINFO_EXTENSION);

        $filename = $file->name ? $file->name . '.' . $ext : $file->filename;
        try {
            return response()->download($path, $filename);
        } catch (\Exception $e) {
            return response()->view('errors.file_not_found', ['message' => $e->getMessage()], 404);
        }
    }
}


if (!function_exists('asset_url')) {

    // @codingStandardsIgnoreLine
    function asset_url($path)
    {
        $path = \App\Helper\Files::UPLOAD_FOLDER . '/' . $path;
        $storageUrl = $path;

        if (!Str::startsWith($storageUrl, 'http')) {
            return url($storageUrl);
        }

        return $storageUrl;
    }
}

if (!function_exists('getDomain')) {

    function getDomain($host = false)
    {
        if (!$host) {
            $host = $_SERVER['SERVER_NAME'] ?? 'tabletrack.test';
        }

        $shortDomain = config('app.short_domain_name');
        $dotCount = ($shortDomain === true) ? 2 : 1;

        $myHost = strtolower(trim($host));
        $count = substr_count($myHost, '.');

        if ($count === $dotCount || $count === 1) {
            return $myHost;
        }

        $myHost = explode('.', $myHost, 2);

        return end($myHost);
    }
}

if (!function_exists('getDomainSpecificUrl')) {

    function getDomainSpecificUrl($url, $restaurant = null)
    {
        // Check if Subdomain module exist
        if (!module_enabled('Subdomain')) {
            return $url;
        }

        config(['app.url' => config('app.main_app_url')]);

        // If restaurant specific
        if ($restaurant) {
            $restaurantUrl = (config('app.redirect_https') ? 'https' : 'http') . '://' . $restaurant->sub_domain;

            config(['app.url' => $restaurantUrl]);
            // Removed Illuminate\Support\Facades\URL::forceRootUrl($companyUrl);

            if (Str::contains($url, $restaurant->sub_domain)) {
                return $url;
            }

            $url = str_replace(request()->getHost(), $restaurant->sub_domain, $url);
            $url = str_replace('www.', '', $url);

            // Replace https to http for sub-domain to
            if (!config('app.redirect_https')) {
                return str_replace('https', 'http', $url);
            }

            return $url;
        }

        // Removed config(['app.url' => $url]);
        // Comment      \Illuminate\Support\Facades\URL::forceRootUrl($url);
        // If there is no restaurant and url has login means
        // New superadmin is created
        return str_replace('login', 'super-admin-login', $url);
    }
}


function module_enabled($moduleName)
{
    return Module::has($moduleName) && Module::isEnabled($moduleName);
}

if (!function_exists('package')) {

    function package()
    {

        if (cache()->has('package')) {
            return cache('package');
        }

        $package = Package::first();

        cache(['package' => $package]);

        return cache('package');
    }
}

function superadminPaymentGateway()
{
    if (cache()->has('superadminPaymentGateway')) {
        return cache('superadminPaymentGateway');
    }

    $payment = SuperadminPaymentGateway::first();

    cache(['superadminPaymentGateway' => $payment]);

    return cache('superadminPaymentGateway');
}


function pusherSettings()
{
    $setting = PusherSetting::first();

    session(['pusherSettings' => $setting]);

    return session('pusherSettings');
}

if (!function_exists('clearRestaurantModulesCache')) {

    function clearRestaurantModulesCache($restaurantId)
    {
        if (is_null($restaurantId)) {
            return true;
        }

        cache()->forget('restaurant_modules_' . $restaurantId);
    }
}

if (!function_exists('currency_format_setting')) {

    // @codingStandardsIgnoreLine
    function currency_format_setting($currencyId = null)
    {
        if (!session()->has('currency_format_setting' . $currencyId) || (is_null($currencyId) && restaurant())) {
            $setting = $currencyId == null ? restaurant()->load('currency')->currency : Currency::where('id', $currencyId)->first();
            session(['currency_format_setting' . $currencyId => $setting]);
        }

        return session('currency_format_setting' . $currencyId);
    }
}

if (!function_exists('currency_format')) {

    // @codingStandardsIgnoreLine
    function currency_format($amount, $currencyId = null, $showSymbol = true)
    {
        $formats = currency_format_setting($currencyId);

        if (!$showSymbol) {
            $currency_symbol = '';
        } else {
            $settings = $formats->restaurant ?? Restaurant::find($formats->restaurant_id);
            $currency_symbol = $currencyId == null ? $settings->currency->currency_symbol : $formats->currency_symbol;
        }

        $currency_position = $formats->currency_position;
        $no_of_decimal = !is_null($formats->no_of_decimal) ? $formats->no_of_decimal : '0';
        $thousand_separator = !is_null($formats->thousand_separator) ? $formats->thousand_separator : '';
        $decimal_separator = !is_null($formats->decimal_separator) ? $formats->decimal_separator : '0';

        $amount = number_format(floatval($amount), $no_of_decimal, $decimal_separator, $thousand_separator);

        $amount = match ($currency_position) {
            'right' => $amount . $currency_symbol,
            'left_with_space' => $currency_symbol . ' ' . $amount,
            'right_with_space' => $amount . ' ' . $currency_symbol,
            default => $currency_symbol . $amount,
        };

        return $amount;
    }
}


if (!function_exists('global_currency_format_setting')) {

    // @codingStandardsIgnoreLine
    function global_currency_format_setting($currencyId = null)
    {
        if (!session()->has('global_currency_format_setting' . $currencyId)) {
            $setting = $currencyId == null ? GlobalCurrency::first() : GlobalCurrency::where('id', $currencyId)->first();
            session(['global_currency_format_setting' . $currencyId => $setting]);
        }

        return session('global_currency_format_setting' . $currencyId);
    }
}

if (!function_exists('global_currency_format')) {

    // @codingStandardsIgnoreLine
    function global_currency_format($amount, $currencyId = null, $showSymbol = true)
    {
        $formats = global_currency_format_setting($currencyId);


        if (!$showSymbol) {
            $currency_symbol = '';
        } else {
            $currency_symbol = $formats->currency_symbol;
        }

        $currency_position = $formats->currency_position;
        $no_of_decimal = !is_null($formats->no_of_decimal) ? $formats->no_of_decimal : '0';
        $thousand_separator = !is_null($formats->thousand_separator) ? $formats->thousand_separator : '';
        $decimal_separator = !is_null($formats->decimal_separator) ? $formats->decimal_separator : '0';

        $amount = number_format($amount, $no_of_decimal, $decimal_separator, $thousand_separator);

        $amount = match ($currency_position) {
            'right' => $amount . $currency_symbol,
            'left_with_space' => $currency_symbol . ' ' . $amount,
            'right_with_space' => $amount . ' ' . $currency_symbol,
            default => $currency_symbol . $amount,
        };

        return $amount;
    }
}

if (!function_exists('smtp_setting')) {

    // @codingStandardsIgnoreLine
    function smtp_setting()
    {
        if (!session()->has('smtp_setting')) {
            session(['smtp_setting' => EmailSetting::first()]);
        }

        return session('smtp_setting');
    }
}

if (!function_exists('custom_module_plugins')) {

    // @codingStandardsIgnoreLine
    function custom_module_plugins()
    {

        if (!cache()->has('custom_module_plugins')) {
            $plugins = \Nwidart\Modules\Facades\Module::allEnabled();
            cache(['custom_module_plugins' => array_keys($plugins)]);
        }

        return cache('custom_module_plugins');
    }
}
