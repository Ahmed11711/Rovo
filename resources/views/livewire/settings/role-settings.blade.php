<div>
    
    <div class="overflow-hidden shadow mb-8">
        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th scope="col"
                class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                    <div class="text-xs font-light">@lang('app.user')</div>
                    <div class="text-sm font-medium">@lang('app.permission')</div>
                </th>

                @foreach ($roles as $item)
                    <th scope="col"
                    class="py-2.5 px-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                        <div class="text-xs font-light">@lang('app.role')</div>
                        <div class="text-sm font-medium">{{ __('modules.staff.'.$item->display_name) }}</div>
                    </th>           
                @endforeach
            </tr>     

        </thead>

        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700" wire:key='perms-list-{{ microtime() }}'>

            @foreach ($permissions as $module)
                <tr>
                    <td class="bg-gray-50 p-4 text-sm font-semibold text-left text-gray-500 uppercase dark:text-gray-400 dark:bg-gray-900" colspan="{{ (count($roles) + 1) }}">
                        {{ __('permissions.modules.'.$module->name) }}
                    </td>
                </tr>
            
                @foreach ($module->permissions as $item)
                
                @php
                    $permissionRoles = $item->roles->pluck('name')->toArray();
                @endphp

                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700" wire:key='perms-item-{{ $item->id . microtime() }}'>
                    <td class="flex items-center px-4 py-2 mr-12 space-x-6 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('permissions.permissions.'.$item->name) }}
                    </td>
    
                    @foreach ($roles as $role)
                    <td class="px-4 py-2 mr-12 space-x-6">
                        @if (!in_array($role->name, $permissionRoles))
                            <x-secondary-button-table wire:click='setPermission({{ $role->id }}, {{ $item->id }})'>
                                &plus;
                            </x-secondary-button-table>
                        @else
                            <x-danger-button-table wire:click='removePermission({{ $role->id }}, {{ $item->id }})'>
                                &minus;
                            </x-danger-button-table>
                        @endif
                    </td>                
                    @endforeach
    
                </tr>
                @endforeach
            @endforeach

        </tbody>
       
    </table>
</div>