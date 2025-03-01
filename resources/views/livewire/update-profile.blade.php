<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">@lang('app.profileInfo')</h2>
        <form wire:submit="submitForm">
          @csrf
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('app.fullName')</label>
                    <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model='fullName'>
                    @error('fullName')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('modules.customer.email')</label>
                    <input type="email" id="email" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model='email'>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('modules.customer.phone')</label>
                    <input type="tel" id="telephone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model='phone'>
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('modules.customer.address')</label>
                    <textarea id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" wire:model='address'>
                    </textarea>
                </div>
            </div>
            <x-button class="mt-4">@lang('app.save')</x-button>
        </form>
    </div>
  </section>