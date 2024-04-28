{{-- View to show product details --}}
{{-- I may delete it later --}}
{{-- Variable $product from ProductController is an array that contains the details from the specific product --}}

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

                    {{-- If $edit is true show the product edit form --}}
                    @if ($editing ?? false)
                        @dump($product)
                        @dump($categories)

                        <form action="{{route('products.update', $product->id)}}" method="POST">
                            @csrf
                            @method('put')
                            <input type="text" name="name" id="name" placeholder="Nombre del producto" value="{{$product->name}}">
                            <br>
                            <input type="number" name="price" id="price" placeholder="Precio" value="{{$product->price}}" step=".01">
                            <br>
                            <input type="text" name="sku" id="sku" placeholder="sku" value="{{$product->sku}}">
                            <br>
                            <input type="text" name="description" id="description" placeholder="Descripcion" value="{{$product->description}}">
                            <br>
                            <select name="category_id" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            
                            <br>
                            <button type="submit">Editar</button>

                    {{-- If $edit is false show the product details (read-only) --}}
                    @else
                        @dump($product)
                        
                    @endif
                    

                </div>
            </div>
        </div>
    </div>

    

    
</x-app-layout>