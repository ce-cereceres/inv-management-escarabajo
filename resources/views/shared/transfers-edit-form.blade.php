<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar almacén') }}
        </h2>
    </x-slot>

    {{-- Show alerts if validation fails --}}
    @include('shared.generic-notification')

    {{-- Product Form --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('transfers.store')}}" method="POST">
                        @csrf
                        <label for="source_warehouse_id">Almacen de origen</label>
                        <select name="source_warehouse_id" id="source_warehouse_id">
                            @foreach ($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <label for="destination_warehouse_id">Almacen de destino</label>
                        <select name="destination_warehouse_id" id="destination_warehouse_id">
                            @foreach ($warehouses as $warehouse)
                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        {{-- LISTA DE PRODUCTOS A ENVIAR --}}
                        <div id="select-container">
                            <div id="select">
                                <select name="product[]" id="product_id">
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="quantity[]" id="quantity" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                            
                        </div>
                        
                        <br>
                        <button id="add-select" type="button">Add Select Field</button>
                        <button type="submit" id="submit_button">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    const selectTemplate = $("#select").clone();
    $("#add-select").click(function() {
        $('#select:first').clone().appendTo('#select-container');
    });
</script>
    
</x-app-layout>