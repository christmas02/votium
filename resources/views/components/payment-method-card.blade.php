@props(['method', 'instruction'])

<div class="col-4">
   @if ($method->value === 'orange_money' || $method->value === 'wave')  {{-- // Exemple de méthode nécessitant une instruction spécifique orange --}}
    <button type="button" 
            class="btn btn-outline-light text-dark border w-100 py-3 payment-btn js-select-method position-relative"
            {{-- Données pour le JS --}}
            data-name="{{ str_replace(['-', '_'], ' ', $method->value) }}"
            data-slug="{{ $method->value }}"
            data-icon="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}"
            data-instruction="{{ $instruction }}"> {{-- ICI: Le message dynamique --}}

        
            <img src="{{ asset(env('IMAGES_PAYMENT') . '/' . $method->icon()) }}" 
             alt="{{ $method->label() }}" 
             class="me-2"
             style="width:50px; height:50px; object-fit: contain;">

        <div class="small fw-bold mt-1">
            {{ str_replace(['-', '_'], ' ', $method->value) }}
        </div>
     
    </button>
    @endif
</div>