<div>
    <x-kot.kot-card :kot='$kot' wire:key='kot-{{ $kot->id . microtime() }}' />
</div>
