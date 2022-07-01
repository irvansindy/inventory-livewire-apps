<div>
    <div x-data="signaturePad(@entangle($attributes->wire('model')))">
        <h1 class="text-xl font-semibold text-gray-700 flex items-center justify-between">
            <span>Signature pad</span>
        </h1>
        <div>
            <canvas x-ref="signature_canvas" class="border rounded shadow">
    
            </canvas>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            // console.log('alpine:init');
            Alpine.data('signaturePad', (value) => ({
                signaturePadInstance: null,
                value: value,
                init(){
                    this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
                    this.signaturePadInstance.addEventListener("endStroke", ()=>{
                    this.value = this.signaturePadInstance.toDataURL('image/png');
                    });
                },
            }))
        })
    </script>
</div>