<div>
    <div wire:ignore>
        <div class="mt-5 relative" wire:ignore>
            <select id="select2-dropdown" name="programming_languages[]" multiple
                class="appearance-none h-full rounded-r border-t border-r border-b block w-full bg-white border-gray-300 text-gray-700 py-2 px-4 pr-8 leading-tight focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
                <option value="" disabled="disabled">Select Option</option>
                @foreach($languages as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                @endforeach
            </select>
            <div x-data="{can:@entangle('prog_lang')}" x-bind:class="can.length > 0 ? 'hidden': 'absolute top-2 right-1'" >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2({
            placeholder: "select languages",
            multiple: true,
            allowClear: true,
        });
        $('#select2-dropdown').on('change', function (e) {
            var data = $('#select2-dropdown').select2("val");
            let closeButton = $('.select2-selection__clear')[0];
            if(typeof(closeButton)!='undefined'){
                if(data.length<=0)
                {
                    $('.select2-selection__clear')[0].children[0].innerHTML = '';
                } else{
                    $('.select2-selection__clear')[0].children[0].innerHTML = 'x';
                }
            }
            @this.set('prog_lang', data);
        });
    });

</script>
@endpush