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
                    <form action="{{route('warehouses.store')}}" method="POST">
                        @csrf
                        <input type="text" name="name" id="name" placeholder="Nombre del almacén">
                        <br>
                        <input type="text" name="street" id="street" placeholder="Dirección">
                        <br>
                        <input type="number" name="streetNumber" id="streetNumber" placeholder="Número exterior">
                        <br>
                        <input type="text" name="zipCode" id="zipCode" placeholder="Codigo Postal">
                        <br>
                        
                        <br>
                        <button type="submit">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>