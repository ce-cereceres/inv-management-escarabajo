<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @include('shared.generic-notification')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mx-auto">
                        <a href="{{route('products.index')}}" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 float-left">

                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Productos</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Mostrar una lista de todos los productos</p>
                        </a>
    
                        <a href="{{route('warehouses.index')}}" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 float-left">
    
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Almacenes</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Mostrar una lista de todos los almacenes</p>
                        </a>
    
                        <a href="{{route('transfers.index')}}" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 float-left">
    
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Transferencias</h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">Ver y realizar transferencias entre almacenes</p>
                        </a>
                    </div>
                    
                        
                        
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
