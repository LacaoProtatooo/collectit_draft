<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Cart</title>
</head>
<body class="">

    @include('common.header')

    <div class="hero min-h-screen bg-transparent">
  <div class="hero-content flex-col lg:flex-row-reverse">

  <div class="bg-cyan-900">
<table class="table bg-cyan-800 text-center">
    <!-- head -->
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        <!-- row 1 -->
        @foreach ($cartItems as $item)
        <tr class="hover:bg-cyan-900">
            <th>1</th>
            <td>{{ $item->name }}</td>
            <td>{{ $item->price }}</td>
            <td>
                <div class="carousel">
                    <div>
                        {{ $item->pivot->quantity }}
                    </div>
                </div>
            </td>
            <td>
                <form action="{{ route('cart.delete', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-red-700 hover w-16 text-white border-r-4 mr-4">Delete</button>
                </form>
            </td>
            <td>
                <form action = "{{ route('cart.add') }}" method = "POST">
                    @csrf
                    @method('POST')
                    <input type = "hidden" name = "id" value = {{ $item->id }}>
                    <button class="btn bg-red-700 hover w-16 text-white border-r-4 mr-4">+</button>
                </form>
                <form action = "{{ route('cart.deduct') }}" method = "POST">
                    @csrf
                    @method('POST')
                    <input type = "hidden" name = "id" value = {{ $item->id }}>
                    <button class="btn bg-red-700 hover w-16 text-white border-r-4 mr-4">-</button>
                </form>

            </td>
        </tr>
        @php
            $subtotal = $item->pivot->quantity * $item->price;
            $total += $subtotal;
        @endphp
        @endforeach

    <tfoot>
        <tr class=" text-white text-2xl text-opacity-50">
            <td colspan="2"></td>
            <td>Subtotal:</td>
            <td>

                {{ $total }}
            </td> <!-- Replace with your actual subtotal calculation -->
        </tr>
    </tfoot>
</table>
</div>

    <div class="card shrink-0 w-full max-w-sm shadow-2xl bg-cyan-900">
    <form class="card-body bg-cyan-900 rounded-md">
        <div class="form-control">
            <label class="label">
                <span class="label-text">Email</span>
            </label>
            <input type="email" placeholder="Email" class="input input-bordered" required />
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Address</span>
            </label>
            <input type="Address" placeholder="Address" class="input input-bordered" required />
        </div>
        <div class="form-control">
            <label class="label">
                <span class="label-text">Courier</span>
            </label>
            <select class="select select-bordered">
                <option value="option1">Option 1</option>
                <option value="option2">Option 2</option>
                <option value="option3">Option 3</option>
            </select>
        </div>
        <div class="form-control mt-6">
            <button class="btn btn-primary">Login</button>
        </div>
    </form>
    <div class="text-center m-4 bg-cyan-900">
        <h2 class=" text-2xl">Total Price: $PLACEHOLDER$</h2>
    </div>
    </div>
  </div>
</div>

    @include('common.footer')
</body>
</html>
