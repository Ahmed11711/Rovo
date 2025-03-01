<div
    class="mx-4 p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

    <h3 class="mb-4 text-xl font-semibold dark:text-white">@lang('modules.settings.emailSettings')</h3>
    <div class="grid ">
        @if ($mailDriver == 'smtp')
            @if(!app()->environment(['codecanyon','demo']))
                <x-alert type="danger" icon="info-circle">
                    <p class="text-sm">
                        It seems you have changed the <code class="font-bold bg-gray-200 text-gray-800 px-1 py-0.5 rounded">APP_ENV=codecanyon</code> to something else in
                        <code class="font-bold bg-gray-200 text-gray-800 px-1 py-0.5 rounded">.env</code>
                        file. Please do not change it, otherwise, the SMTP details below won't be taken from here.
                    </p>
                </x-alert>
            @endif
            @if ($verified)
                <x-alert type="success" icon="info-circle">
                    @lang('messages.smtpSuccess')
                </x-alert>
            @else

                @if(!$formSubmitting)
                    <x-alert type="danger" icon="info-circle">
                        @lang('messages.smtpError')
                    </x-alert>
                @endif

                <x-alert type="secondary" icon="info-circle">
                    <div>
                        <strong>@lang('messages.smtpRecommendation')</strong>
                        <ul>
                            <li class="py-2 tracking-wide">1. <a class="underline underline-offset-1"
                                                                 href="https://get.smtp2go.com/tabletrack"
                                                                 target="_blank">SMTP2GO.COM</a></li>
                            <li class=" tracking-wide">2. <a class="underline underline-offset-1"
                                                             href="https://pstk.smtp.com/froiden" target="_blank">SMTP.COM</a>
                            </li>
                        </ul>
                    </div>
                </x-alert>

            @endif

        @endif


    </div>
    <form wire:submit="submitForm" class="space-y-6">
        @if (session()->has('success'))
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Error Message -->
        @error('smtp_error')
        <x-alert type="danger">
            <div>
                {!! $message !!}
            </div>
        </x-alert>
        @enderror

        <div class="grid gap-6 lg:grid-cols-4">


            <div>
                <x-label for="mailFromName" :value="__('modules.settings.mailFromName')"/>
                <x-input type='text' id="mailFromName" class="mt-1 block w-full" wire:model="mailFromName"/>
                <x-input-error for="mailFromName" class="mt-2"/>
            </div>

            <div>
                <x-label for="mailFromEmail" :value="__('modules.settings.mailFromEmail')"/>
                <x-input type="text" id="mailFromEmail" class="mt-1 block w-full" wire:model="mailFromEmail"/>
                <x-input-error for="mailFromEmail" class="mt-2"/>
            </div>

            <div>
                <x-label for="enableQueue" :value="__('modules.settings.enableQueue')"/>
                <x-select id="enableQueue" class="mt-1 block w-full" wire:model="enableQueue">
                    <option value="yes">@lang('app.yes')</option>
                    <option value="no">@lang('app.no')</option>
                </x-select>
                <x-input-error for="enableQueue" class="mt-2"/>
            </div>

            <div>
                <x-label for="mailDriver" :value="__('modules.settings.mailDriver')"/>
                <x-select id="mailDriver" class="mt-1 block w-full" wire:model.live="mailDriver">
                    <option value="mail">Mail</option>
                    <option value="smtp">SMTP</option>
                </x-select>
                <x-input-error for="mailDriver" class="mt-2"/>
            </div>

        </div>

        @if ($mailDriver == 'smtp')
            <div class="grid gap-6 lg:grid-cols-4">
                <div>
                    <x-label for="smtpHost" :value="__('modules.settings.smtpHost')"/>
                    <x-input type='text' id="smtpHost" class="mt-1 block w-full" wire:model="smtpHost"/>
                    <x-input-error for="smtpHost" class="mt-2"/>
                </div>
                <div>
                    <x-label for="smtpPort" :value="__('modules.settings.smtpPort')"/>
                    <x-input type='text' id="smtpPort" class="mt-1 block w-full" wire:model="smtpPort"/>
                    <x-input-error for="smtpPort" class="mt-2"/>
                </div>
                <div>
                    <x-label for="mailUsername" :value="__('modules.settings.mailUsername')"/>
                    <x-input type='text' id="mailUsername" class="mt-1 block w-full" wire:model="mailUsername"/>
                    <x-input-error for="mailUsername" class="mt-2"/>
                </div>
                <div>
                    <x-label for="mailPassword" :value="__('modules.settings.mailPassword')"/>
                    <x-input-password type='password' id="mailPassword" class="mt-1 block w-full" wire:model="mailPassword"/>
                    <x-input-error for="mailPassword" class="mt-2"/>
                </div>
                <div>
                    <x-label for="smtpEncryption" :value="__('modules.settings.smtpEncryption')"/>
                    <x-select id="smtpEncryption" class="mt-1 block w-full" wire:model.live="smtpEncryption">
                        <option value="tls">tls</option>
                        <option value="ssl">ssl</option>
                        <option value="starttls">starttls</option>
                        <option value="null">none</option>
                    </x-select>
                    <x-input-error for="smtpEncryption" class="mt-2"/>
                </div>

            </div>
        @endif


        <div class="flex gap-2">
            <div>
                <x-button>@lang('app.save')</x-button>
            </div>
            @if ($mailDriver == 'smtp')
                <div>
                    <x-button type="button" wire:click="$set('showTestEmailModal', true)" secondary>
                        Test SMTP
                    </x-button>
                </div>
            @endif
        </div>
    </form>

    <!-- Test Email Modal -->
    <x-dialog-modal wire:model.live="showTestEmailModal">
        <x-slot name="title">
            Test SMTP Settings
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                @if($testEmailStatus)
                    <div class="mb-4">
                        @if($testEmailStatus === 'success')
                            <x-alert type="success" icon="check-circle">
                                {{ $testEmailMessage }}
                            </x-alert>
                        @else
                        <div class="w-full break-all items-center p-4 mb-4 text-sm rounded-lg text-red-800 border border-red-300 bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" icon="x-circle" role="alert">

        {{ $testEmailMessage }}
                    </div>


                        @endif
                    </div>
                @endif

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Send a test email to verify your SMTP settings.
                </p>
                <div>
                    <x-label for="testEmail" :value="__('Email Address')" />
                    <x-input type="email"
                        id="testEmail"
                        class="mt-1 block w-full"
                        wire:model="testEmail"
                        placeholder="Enter email address"
                    />
                    <x-input-error for="testEmail" class="mt-2"/>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
            <x-secondary-button wire:click="closeTestEmailModal" wire:loading.attr="disabled">
            {{ $testEmailStatus === 'success' ? __('app.close') : __('app.cancel') }}
            </x-secondary-button>

                @if($testEmailStatus !== 'success')
                    <x-button wire:click="sendTestEmail" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="sendTestEmail">Send Test Email</span>
                        <span wire:loading wire:target="sendTestEmail">Sending...</span>
                    </x-button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
