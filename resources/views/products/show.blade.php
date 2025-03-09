<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-navy min-h-screen flex items-center justify-center">
    <div class="max-w-sm bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Foto Produk dengan Bingkai Persegi -->
        <div class="w-full aspect-w-1 aspect-h-1">
            <img class="w-full h-full object-cover" src="{{ asset('/storage/products/'.$product->image) }}" alt="Product Image">
        </div>
        
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">{{ $product->title }}</h2>
            <p class="mt-2 text-gray-600">{!! $product->description !!}</p>
            
            <!-- Input Stock -->
            <div class="mt-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock : {{ $product->stock }}</label>
            </div>
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
    <script>
    function calculatetotal() {
        var quantity = document.getElementById("quantity").value;
        var pricePerItem = {{ $product->price }}; // Harga produk dari database
        var totalPrice = quantity * pricePerItem;
        document.getElementById("totalprice").innerText = totalPrice.toLocaleString('id-ID');
    }
</script>
<script>
    @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
