<div style="text-align: center;">
    @for ($i = 0; $i < 19; $i++)
        {!! DNS1D::getBarcodeHTML($product->barcode, 'C128',3,33, 'black', true) !!}
        <br>
    @endfor
    
</div>