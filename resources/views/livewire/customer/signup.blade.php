<div>
    <x-dialog-modal wire:model.live="showSignupModal"  maxWidth="md">
        <x-slot name="title">
            {{-- <h2 class="text-lg">@lang('app.login')</h2> --}}
        </x-slot>

        <x-slot name="content">

            @if (!$showVerifcationCode)
            <form wire:submit="submitForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-label for="customerEmail" value="{{ __('app.email') }}" />
                        <x-input id="customerEmail" class="block mt-1 w-full" type="email" wire:model='email' />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    
                </div>
                   
                <div class="flex justify-between w-full pb-4 space-x-4 mt-6">
                    <x-button>@lang('app.continue')</x-button>
                    <x-button-cancel  wire:click="$toggle('showSignupModal')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
                </div>
            </form>
            @endif


            @if ($showVerifcationCode)
            <form wire:submit="submitVerification">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-label for="verificationCode" value="{{ __('app.verificationCode') }}" />
                        <x-input id="verificationCode" class="block mt-1 w-full" type="tel" wire:model='verificationCode' />
                        <x-input-error for="verificationCode" class="mt-2" />
                    </div>

                    <div>
                        <a href="javascript:;" class="text-sm underline underline-offset-2 text-gray-600" wire:click='sendVerification'>@lang('app.resendVerificatonCode')</a>
                    </div>
                </div>
                   
                <div class="flex justify-between w-full pb-4 space-x-4 mt-6">
                    <x-button>@lang('app.continue')</x-button>
                    <x-button-cancel  wire:click="$toggle('showSignupModal')" wire:loading.attr="disabled">@lang('app.cancel')</x-button-cancel>
                </div>
            </form>
            @endif

        </x-slot>

    </x-dialog-modal>
</div>
