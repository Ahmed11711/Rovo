<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\OnboardingStep;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Auth;

class FortifyServiceProvider extends ServiceProvider
{

    use AppBoot;

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {

            public function toResponse($request)
            {
                session(['user' => User::find(user()->id)]);

                if (user()->hasRole('Admin_' . user()->restaurant_id)) {
                    $onboardingSteps = OnboardingStep::where('branch_id', user()->restaurant->branches->first()->id)->first();

                    if (
                        $onboardingSteps
                        && (
                            !$onboardingSteps->add_area_completed
                            || !$onboardingSteps->add_table_completed
                            || !$onboardingSteps->add_menu_completed
                            || !$onboardingSteps->add_menu_items_completed
                        )
                    ) {
                        return redirect(RouteServiceProvider::ONBOARDING_STEPS);
                    }
                }

                if (user()->hasRole('Super Admin')) {
                    return redirect(RouteServiceProvider::SUPERADMIN_HOME);
                }

                return redirect(session()->has('url.intended') ? session()->get('url.intended') : RouteServiceProvider::HOME);
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::loginView(function () {
            $this->showInstall();

            $this->checkMigrateStatus();

            if (!$this->isLegal()) {
                if (!module_enabled('Subdomain')) {
                    return redirect('verify-purchase');
                }

                // We will only show verify page for super-admin-login
                // We will check it's opened on main or not
                if (Str::contains(request()->url(), 'super-admin-login')) {
                    return redirect('verify-purchase');
                }
            }

            return view('auth.login');
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::authenticateUsing(function (Request $request) {
            $rules = [
                'email' => 'required|email:rfc|regex:/(.+)@(.+)\.(.+)/i'
            ];

            $request->validate($rules);

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {

                // Added for validation of account login in restaurant
                User::validateLoginActiveDisabled($user);

                return $user;
            }
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }

    public function checkMigrateStatus()
    {
        return check_migrate_status();
    }
}
