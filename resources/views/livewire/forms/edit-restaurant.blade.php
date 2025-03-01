<div>
    <form wire:submit="submitForm">
        @csrf

        <div>
            <x-label for="restaurantName" value="{{ __('modules.restaurant.name') }}" />
            <x-input id="restaurantName" class="block mt-1 w-full" type="text" wire:model='restaurantName' />
            <x-input-error for="restaurantName" class="mt-2" />
        </div>

        @includeIf('subdomain::super-admin.restaurant.subdomain-field', ['restaurant' => $restaurant])

        <div class="mt-4">
            <x-label for="email" value="{{ __('app.email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" wire:model='email' />
            <x-input-error for="email" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="phone" value="{{ __('modules.restaurant.phone') }}" />
            <x-input id="phone" class="block mt-1 w-full" type="tel" wire:model='phone' />
            <x-input-error for="phone" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="address" value="{{ __('modules.settings.restaurantAddress') }}" />
            <x-textarea id="address" class="block mt-1 w-full" wire:model='address' rows="3" />
            <x-input-error for="address" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-label for="country" value="{{ __('Country') }}" />
            <x-select id="restaurantCountry" class="mt-1 block w-full" wire:model="country">
                @foreach ($countries as $item)
                <option value="{{ $item->id }}">{{ $item->countries_name }}</option>
                @endforeach
            </x-select>
            <x-input-error for="country" class="mt-2" />
        </div>

         <div class="mt-4">
                <x-label for="facebook" value="{{ __('modules.settings.facebook_link') }}" />
                <x-input id="facebook" class="block mt-1 w-full" type="url"
                   autofocus wire:model='facebook' />
                <x-input-error for="facebook" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="instagram" value="{{ __('modules.settings.instagram_link') }}" />
                <x-input id="instagram" class="block mt-1 w-full" type="url"
                    autofocus wire:model='instagram' />
                <x-input-error for="instagram" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-label for="twitter" value="{{ __('modules.settings.twitter_link') }}" />
                <x-input id="twitter" class="block mt-1 w-full" type="url"
                   autofocus wire:model='twitter' />
                <x-input-error for="twitter" class="mt-2" />
            </div>

        <div class="mt-4">
            <x-label for="status" value="{{ __('app.status') }}"/>
            <x-select id="status" class="mt-1 block w-full" wire:model="status">
                <option value="1">{{ __('app.active') }}</option>
                <option value="0">{{ __('app.inactive') }}</option>
            </x-select>
            <x-input-error for="status" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="ms-4">
                {{ __('app.save') }}
            </x-button>
        </div>

    </form>

</div>
