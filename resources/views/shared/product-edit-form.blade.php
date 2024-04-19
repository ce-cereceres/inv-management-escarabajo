<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Productos') }}
        </h2>
    </x-slot>

    {{-- Show alerts if validation fails --}}
    @include('shared.generic-notification')

    {{-- Product Form --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('products.store')}}" method="POST">
                        @csrf
                        <input type="text" name="name" id="sku" placeholder="Nombre del producto">
                        <br>
                        <input type="number" name="price" id="price" placeholder="Precio">
                        <br>
                        <input type="text" name="sku" id="sku" placeholder="sku">
                        <br>
                        <input type="text" name="description" id="description" placeholder="Descripcion">
                        <br>
                        <select name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        
                        <br>
                        <button type="submit">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>