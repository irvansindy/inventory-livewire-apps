<div  class="relative shadow-xl bg-white rounded-lg p-6 flex flex-col gap-4">
    <x-signature-pad wire:model.defer="signature">

    </x-signature-pad>
    <button wire:click="submit" class="bg-cyan-600 hover:bg-cyan-800 text-white font-bold py-2 px-4 mb-4 rounded place-items-end">
        Submit
    </button>
</div>