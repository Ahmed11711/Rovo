<div>
    <input x-data x-cloak x-init="new Pikaday({
        field: $refs.input,
        format:'DD-MM-YYYY',
    onSelect: function (date) {
        let options = { day: '2-digit', month: 'long', year: 'numeric' };
        let formattedDate = date.toLocaleDateString(date, options);
        $dispatch('input', formattedDate)
    }});" x-ref="input" type="text" {!! $attributes->merge(['class' =>
    'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-lg text-lg text-gray-700 dark:text-gray-300  shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 w-full justify-between']) !!}>
</div>
