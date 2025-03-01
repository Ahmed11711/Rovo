<div>
    <p class="t-body size-m -color-mid mt-2 mb-2 pb-2">
        <a href="javascript:;" wire:click="openModal" class="text-blue-500 underline hover:text-blue-700">
            How much do I save by extending now?
        </a>
    </p>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" wire:click.self="closeModal">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative">
                <button class="absolute top-0 right-0 mt-2 mr-2 text-gray-600 hover:text-gray-900" wire:click="closeModal">
                    &times;
                </button>
                <div class="text-center">
                    <img src="{{ asset('img/Support_Extension_Cost.jpg') }}" alt="Support Extension Cost" class="max-w-full max-h-full mb-4">
                </div>
            </div>
        </div>
    @endif
</div> 