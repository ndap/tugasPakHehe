<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Products - SantriKoding.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <img src="{{ asset('/storage/products/'.$product->image) }}" class="rounded" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                   <h3>{{ $product->title }}</h3>
                        <hr/>
                        <p>{{ "Rp " . number_format($product->price,2,',','.') }}</p>
                        <code>
                            <p>{!! $product->description !!}</p>
                        </code>
                        <hr/>
                        <p>Stock : {{ $product->stock }}</p>
                        
                        <!-- Form Pembelian -->
                        <form action="{{ route('products.purchase', $product->id) }}" method="POST">
                        @csrf
                        <div class="form-group" style="width:25%; text-align: left;">
                         <input type="number" id="quantity" name="quantity" class="form-control" min="1" placeholder="Jumlah" required oninput="calculatetotal()">
                         <p>Total Harga: Rp <span id="totalprice">0</span></p>
                         <button type="submit" class="btn btn-success mt-2" style="width: 100%">Beli</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function calculatetotal() {
        var quantity = document.getElementById("quantity").value;
        var pricePerItem = {{ $product->price }}; // Harga produk dari database
        var totalPrice = quantity * pricePerItem;
        document.getElementById("totalprice").innerText = totalPrice.toLocaleString('id-ID');
    }
</script>
</body>
</html>