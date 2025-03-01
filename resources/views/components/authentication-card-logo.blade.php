<a  class="flex gap-2 items-center text-xl font-medium dark:text-white">
    <img src="{{ global_setting()->logoUrl }}" class="h-8" alt="{{global_setting()->name}} Logo" /> 
    @if (global_setting()->show_logo_text)
    {{ global_setting()->name }}
    @endif
</a>
