<table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200', 'id' => 'example' ]) }}>
    @isset($thead)
        <thead class="{{ $headType ?? 'bg-gray-50' }}">
            <tr>
                {!! $thead !!}
            </tr>
        </thead>
    @endisset
    <tbody class="bg-white divide-y divide-gray-200">
        {{ $slot }}
    </tbody>
    @isset($tfoot)
        <tfoot class="bg-gray-50">
            {{ $tfoot }}
        </tfoot>
    @endisset
</table>
