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
                    <a href="{{route('products.create')}}">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>                              
                            Crear Producto
                        </button>
                    </a>
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
                    <th scope="col" class="px-6 py-3">Stock</th>
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
                        {{-- sum quantityAvailable --}}
                        <td class="px-6 py-4">
                            {{$product->warehouses->sum('pivot.quantityAvailable')}}
                        </td>
                        {{-- Price --}}
                        <td class="px-6 py-4">{{$product->price}}</td>
                        {{-- SKU --}}
                        <td class="px-6 py-4">{{$product->sku}}</td>
                        {{-- Description --}}
                        <td class="px-6 py-4">{{$product->description}}</td>
                        {{-- Category Name --}}
                        <td class="px-6 py-4">{{$product->category->name}}</td>

                        {{-- Actions --}}
                        <td class="px-6 py-4">
                            <a href="{{route('products.edit', $product->id)}}">Editar</a>
                            {{-- <a href="{{route('products.destroy', $product->id)}}">Delete</a> --}}
                            <form action="{{route('products.destroy', $product->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button>Eliminar</button>
                            </form>
                        
                        
                        </td>
                    </tr>               
                @endforeach
            </tbody>            
            
        </table>
    </div>

    
</x-app-layout>