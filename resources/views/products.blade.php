{{-- retrive data from ProductController method index --}}
{{-- list of all products from loged user as $products --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    

    <div class="py-12">
        @include('shared.generic-notification')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <br>
                    <a href="{{route('products.create')}}">Crear Producto</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Table of products --}}

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Precio</th>
                    <th scope="col" class="px-6 py-3">sku</th>
                    <th scope="col" class="px-6 py-3">Descripción</th>
                    <th scope="col" class="px-6 py-3">Categoria</th>
                    <th scope="col" class="px-6 py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$product->name}}</th>
                        <td class="px-6 py-4">{{$product->price}}</td>
                        <td class="px-6 py-4">{{$product->sku}}</td>
                        <td class="px-6 py-4">{{$product->description}}</td>
                        <td class="px-6 py-4">{{$product->category_id}}</td>
                        <td class="px-6 py-4">
                            <a href="{{route('products.show', $product->id)}}">Ver</a>
                            <a href="{{route('products.edit', $product->id)}}">Editar</a>
                            <a href="{{route('products.index', $product->id)}}">Delete</a> {{-- TODO --}}
                        
                        
                        </td>
                    </tr>               
                @endforeach
            </tbody>            
            
        </table>
    </div>

    
</x-app-layout>