@props([
    'shape' => 'circle', // circle or rectangle
    'seats' => 4,
    'code' => '',
    'status' => 'available',
    'isInactive' => false,
    'kotCount' => 0
])

@php
    $tableSize = match(true) {
        $seats >= 8 => 'h-44 w-44',
        $seats >= 6 => 'h-40 w-40',
        default => 'h-36 w-36'
    };
    
    $tableShape = $shape === 'rectangle' ? 'rounded-xl' : 'rounded-full';
    
    // Simple status-based styling
    $statusStyles = [
        'available' => [
            'table' => 'bg-green-100 border-green-300',
            'status' => 'bg-green-500',
            'text' => 'text-green-700'
        ],
        'reserved' => [
            'table' => 'bg-red-100 border-red-300',
            'status' => 'bg-red-500',
            'text' => 'text-red-700'
        ],
        'running' => [
            'table' => 'bg-blue-100 border-blue-300',
            'status' => 'bg-blue-500',
            'text' => 'text-blue-700'
        ]
    ][$status] ?? [
        'table' => 'bg-gray-100 border-gray-300',
        'status' => 'bg-gray-500',
        'text' => 'text-gray-700'
    ];

    // Calculate positions for chairs
    $chairPositions = [];
    $baseRadius = match(true) {
        $seats >= 8 => 6,
        $seats >= 6 => 5.5,
        default => 5
    };
    
    $seats = min($seats, 12);
    for ($i = 0; $i < $seats; $i++) {
        $angle = ($i * 360 / $seats) - 90;
        $radian = deg2rad($angle);
        $radius = $baseRadius + (($i % 2) * 0.2);
        $x = cos($radian) * $radius;
        $y = sin($radian) * $radius;
        
        $chairPositions[] = [
            'x' => $x,
            'y' => $y,
            'rotation' => $angle + 90
        ];
    }
@endphp

<div class="relative group p-8" style="width: fit-content">
    <!-- Status Indicator -->

    <!-- Table -->
    <div {{ $attributes->merge([
        'class' => "{$tableSize} {$tableShape} relative cursor-pointer transition-all duration-300 hover:scale-105 border-2 shadow-md " . 
        $statusStyles['table'] . ' ' .
        ($isInactive ? 'opacity-50' : '')
    ]) }}>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            <span class="text-2xl font-bold {{ $statusStyles['text'] }}">{{ $code }}</span>
            <span class="text-sm font-medium text-gray-600">{{ $seats }} @lang('modules.table.seats')</span>
            @if($kotCount > 0)
                <div class="mt-2 px-3 py-1 rounded-full text-xs font-medium bg-white shadow-sm {{ $statusStyles['text'] }}">
                    {{ $kotCount }} @lang('modules.order.kot')
                </div>
            @endif
        </div>
    </div>

</div> 