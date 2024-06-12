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
                    <a href="{{route('transfers.create')}}">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>                              
                            Nueva Transferencia
                        </button>
                    </a>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Traspaso</th>
                            <th scope="col" class="px-6 py-3">Origen</th>
                            <th scope="col" class="px-6 py-3">Destino</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $transfer)        
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$transfer->id}}</th>
                                <td class="px-6 py-4">{{$transfer->sourceWarehouse->name}}</td>
                                <td class="px-6 py-4">{{$transfer->destinationWarehouse->name}}</td>
                                <td class="px-6 py-4">{{$transfer->status}}</td>
                                <td class="px-6 py-4">
                                    <a href="{{route('transfers.show', $transfer->id)}}">
                                        @if ($transfer->status == 'iniciado')
                                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            {{'Enviar'}}
                                        </button>
                                            

                                        @else
                                        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            {{'Ver'}}
                                        </button>
                                        @endif
                                        
                                    </a>
                                    @if ($transfer->status !== 'enviado')
                                        <form action="{{route('transfers.destroy', $transfer->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('¿Estas seguro que deseas eliminar esta transferencia?.')" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                    
                                
                                </td>
                            </tr>               
                        @endforeach
                    </tbody>            
                    
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
