<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transferencia') }}
        </h2>
    </x-slot>

    

    <div class="py-12">
        @include('shared.generic-notification')
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            

            {{-- Verificar que la transferencia se haya iniciado --}}

            @if ($transfer->status === 'iniciado')
                {{-- Detalles de la transferencia --}}

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h1>Detalles de la transferencia</h1>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Traspaso</th>
                                <th scope="col" class="px-6 py-3">Origen</th>
                                <th scope="col" class="px-6 py-3">Destino</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                {{-- ID Transferencia --}}
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$transfer->id}}</th>
                                {{-- Almacen de origen --}}
                                <td class="px-6 py-4">
                                    {{$transfer->sourceWarehouse->name}}
                                </td>
                                {{-- Almacen de destino --}}
                                <td class="px-6 py-4">{{$transfer->destinationWarehouse->name}}</td>
                                {{-- estado --}}
                                <td class="px-6 py-4">{{$transfer->status}}</td>
                            </tr>               

                        </tbody>            
                        
                    </table>
                </div>

                {{-- Detalles de los productos --}}

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h1>Detalles de los productos</h1>
                    
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre del producto</th>
                                <th scope="col" class="px-6 py-3">Cantidad a enviar</th>
                                <th scope="col" class="px-6 py-3">Stock en origen</th>
                                <th scope="col" class="px-6 py-3">Stock en Destino</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($transfer->products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    {{-- Nombre del producto --}}
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$product->name}}</th>
                                    {{-- Cantidad a enviar --}}
                                    <td class="px-6 py-4">
                                        {{$product->pivot->quantity}}
                                    </td>
                                    {{-- Stock en origen --}}
                                    <td class="px-6 py-4">
                                        {{$product->getTransferData($product->id, $transfer->sourceWarehouse->id)}}
                                    </td>
                                    {{-- Stock en Destino --}}
                                    <td class="px-6 py-4">
                                        {{$product->getTransferData($product->id, $transfer->destinationWarehouse->id)}}
                                    </td>
                                </tr>  
                            @endforeach
                                        

                        </tbody>            
                        
                    </table>
                </div>


                <form action="{{route('transfers.confirm', $transfer->id)}}" method="POST">
                    @csrf
                    @method('put')
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Enviar
                    </button>
                </form>
            @else
                {{-- Detalles del envio --}}

                {{-- Detalles de la transferencia --}}

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h1>Detalles de la transferencia</h1>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Traspaso</th>
                                <th scope="col" class="px-6 py-3">Origen</th>
                                <th scope="col" class="px-6 py-3">Destino</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                {{-- ID Transferencia --}}
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$transfer->id}}</th>
                                {{-- Almacen de origen --}}
                                <td class="px-6 py-4">
                                    {{$transfer->sourceWarehouse->name}}
                                </td>
                                {{-- Almacen de destino --}}
                                <td class="px-6 py-4">{{$transfer->destinationWarehouse->name}}</td>
                                {{-- estado --}}
                                <td class="px-6 py-4">{{$transfer->status}}</td>
                            </tr>               

                        </tbody>            
                        
                    </table>
                </div>

                {{-- Detalles de los productos --}}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <h1>Detalles de los productos</h1>
                    
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre del producto</th>
                                <th scope="col" class="px-6 py-3">Cantidad enviada</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach ($transfer->products as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    {{-- Nombre del producto --}}
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$product->name}}</th>
                                    {{-- Cantidad a enviar --}}
                                    <td class="px-6 py-4">
                                        {{$product->pivot->quantity}}
                                    </td>
                                </tr>  
                            @endforeach
                                        
                        </tbody>
                        
                    </table>
                </div>
            @endif
            
        </div>
    </div>

    

    
</x-app-layout>