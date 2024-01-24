@extends('layouts.app')

@php
    function rupiah($angka)
    {
        $hasil_rupiah = 'Rp' . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header fs-5 fw-bold">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->role == 'siswa')
                        <div class="card shadow-sm">
                                <div class="card-header fw-bold">
                                    Balance
                                </div>
                                <div class="card-body">                       
                                    <div class="row">
                                            <div class="col">
                                                <div class="">
                                                    <h4 class="card-text">{{ rupiah($saldo) }}</h4>
                                                </div>
                                            </div>
                                            <div class="col text-end">
                                                <button type="button" class="btn btn-success px-5" data-bs-target="#formTransfer" data-bs-toggle="modal">Withdraw</button>
                                                <button type="button" class="btn btn-success px-5" data-bs-target="#formTopUp" data-bs-toggle="modal">Top Up</button>

                                                <!-- Modal -->
                                                <form action="{{ route('topupNow') }}" method="post">
                                                    @csrf
                                                    <div class="modal fade" id="formTopUp" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <input type="number" name="credit" id=""
                                                                            class="form-control" min="10000" value="10000">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Top Up Now</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Modal Tarik Tunai -->
                                                <form action="{{ route('withdrawNow') }}" method="post">
                                                    @csrf
                                                    <div class="modal fade" id="formTransfer" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Withdraw</h1>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <input type="number" name="debit" id=""
                                                                            class="form-control" min="10000" value="10000">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Withdraw Now</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- End Modal Tarik Tunai -->
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <!-- Row start -->
                            <div class="row">
                                <div class="col-sm-12 col-lg-4 ">
                                    <div class="card">
                                        <div class="card-header fw-bold">
                                            Keranjang
                                        </div>
                                        <div class="card-body">
                                            @foreach ($carts as $key => $cart)    
                                                <div class="row">
                                                    <div class="col col-8 d-flex align-items-center mb-4 mt-2">                                                      
                                                        @if ($cart->product->stock <= 0)
                                                        <s>
                                                        @endif
                                                            {{ $cart->product->name }} | {{ $cart->quantity }} * {{ rupiah($cart->price) }}
                                                        @if ($cart->product->stock <= 0)
                                                        </s>                                         
                                                        @endif
                                                    </div>
                                                    <div class="col col-4 d-flex justify-content-end">
                                                        <form action="{{ route('deleteKart',['id' => $cart->id])}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger bi bi-trash"></button>
                                                        </form>
                                                    </div>
                                                </div>                                            
                                            @endforeach
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <span class="">Total Biaya :</span>
                                                    <h4 class="">{{ rupiah($total_biaya) }}</h4>
                                                </div>
                                                <div class="col text-end">
                                                    <form action="{{ route('payNow')}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn {{ $saldo < $total_biaya || $total_biaya == 0 ? 'btn-secondary' : 'btn-success'  }} ">Checkout</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="card mt-1">
                                            <div class="card-header fw-bold">
                                                    Riwayat Transaksi
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group border-0">   
                                                    @foreach ($transactions as $key => $transaction)    
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <div class="col fw-bold">
                                                                        {{ $transaction[0]->order_id }}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col text-secondary" style="font-size: 12px">
                                                                        {{ $transaction[0]->created_at }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col d-flex justify-content-end align-items-center">
                                                                <a href="{{ route('download', ['order_id' => $transaction[0]->order_id]) }}" class="btn btn-primary">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>                                 
                                                    @endforeach                                         
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="">
                                            <div class="card">
                                                <div class="card-header fw-bold">
                                                    Mutasi Wallet
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group">       
                                                        @foreach ($mutasi as $data)    
                                                            <li>
                                                                {{ $data->credit ? ($data->credit) : 'Debit' }} | {{ $data->debit ? ($data->debit) : 'Credit' }}  | {{ $data->description }}
                                                                @if ($data->status == 'proses')
                                                                    <span class="badge text-bg-warning" >PROSES</span>
                                                                @endif
                                                            </li>         
                                                        @endforeach                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-header fw-bold">Produk Katalog</div>
                                        <div class="card-body">
                                            <div class="row row-cols-1 row-cols-md-3 g-4 ">
                                                @foreach ($products as $key => $product )
                                                        <div class="col col-sm-12 ">
                                                            <form method="POST" action="{{ route('addtoCart') }}" >
                                                                @csrf
                                                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                                <input type="hidden" value="{{ $product->price }}" name="price">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        {{ $product->name }}
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class=" d-flex justify-content-center align-items-center mb-3" style="height: 150px">
                                                                            <img src="{{ $product->photo }}" style="width: 125px">
                                                                        </div>
                                                                        <div>{{ $product->description }}</div>
                                                                        <div>Harga:  {{ rupiah($product->price) }} </div>
                                                                        <div>Stock: {{ $product->stock }}</div>
                                                                    </div>
                                                                    <div class="card-footer">
                                                                        <div class="mb-3 ">
                                                                            <input class="form-control" type="number" name="quantity" value="1" min="1">
                                                                        </div>
                                                                        <div class="d-grid gap-2">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="bi bi-cart3"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </form>
                                                        </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                    @endif

                    @if (Auth::user()->role == 'bank')
                        <div class="row">
                            <div class="col col-4">
                                <div class="card mb-3">
                                    <div class="card-header fw-bold fs-5">
                                        Request
                                    </div>
                                    <div class="card-body">
                                        <div class="row ">
                                            @foreach ($request_topup as $request)    
                                                <div class="col mb-3">
                                                    <form method="POST" action="{{ route('acceptRequest') }}">
                                                        @csrf
                                                        <input type="hidden" value="{{ $request->id }}" name="wallet_id">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                {{ $request->user->name }}
                                                            </div>
                                                            <div class="card-body">
                                                                @if ($request->credit)
                                                                    <span class="text-warning" >Top Up:</span> {{ rupiah($request->credit) }}
                                                                @elseif ($request->debit)
                                                                    <span class="text-danger" >Withdraw:</span> {{ rupiah($request->debit) }}                                                                  
                                                                @endif

                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="submit" class="btn btn-primary">Accept Request</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>      
                                <div class="card mb-3">
                                    <div class="card-header fw-bold fs-5" style="">
                                        Saldo
                                    </div>
                                    <div class="card-body">
                                        {{ rupiah($saldo) }}
                                    </div>
                                </div>                                                                     
                                <div class="card mb-3">
                                    <div class="card-header fw-bold fs-5" style="">
                                        Nasabah
                                    </div>
                                    <div class="card-body">
                                        {{ $nasabah }}
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header fw-bold fs-5" style="">
                                        Transaksi
                                    </div>
                                    <div class="card-body">
                                        {{ $transactions }}
                                    </div>
                                </div>
                            </div>
                            <div class="col col-8">
                                <div class="card ">
                                    <div class="card-header fw-bold fs-5">
                                        <div>
                                            Riwayat Transaksi
                                        </div>
                                        <a href="/riwayat" style="font-size: small;">Lihat Semua</a>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group border-0">                                            
                                            @foreach ($mutasi as $data)
                                                <li class="list-group-item">
                                                    <div>
                                                        <div>
                                                            @if ($data->credit)
                                                            <span class="text-warning fw-bold" >Credit: </span>
                                                                {{ rupiah($data->credit) }}
                                                            @else
                                                            <span class="text-danger fw-bold" >Debit:</span>
                                                            {{ rupiah($data->debit) }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    Name: {{ $data->user->name }}
                                                    <p> {{ $data->description }} </p>
                                                    <p> {{ $data->created_at }} </p>
                                                </li>
                                            @endforeach                          
                                        </ul>
                                    </div>
                                </div>                                                         
                            </div>
                        </div>                               
                    @endif

                    @if (Auth::user()->role == 'kantin')
                        <div class="row">              
                            <div class="col col-8">
                                <div class="card mb-3">
                                    <div class="card-header fs-5 fw-bold d-flex justify-content-between align-items-center ">                
                                        <div>
                                            Produk Katalog
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- <input type="number" min="10000" class="form-control" value="10000" name="credit"> --}}
                                                            <div class="container">
                                                                <div class="row justify-content-center">                                                                                                       
                                                                    <div>
                                                                        {{-- TAMBAH PRODUK --}}
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                            Add Menu
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <form action="{{ route('product.store') }}" method="POST" enctype="">
                                                                                    @csrf
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <div class="mb-3">
                                                                                                <label>Name</label>
                                                                                                <input type="text" name="name" class="form-control" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <div class="mb-3">
                                                                                                <label>Price</label>
                                                                                                <input type="number" name="price" class="form-control">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <div class="mb-3">
                                                                                                <label>Stock</label>
                                                                                                <input type="number" name="stock" class="form-control">
                                                                                            </div>
                                                                                        </div>                                                                              
                                                                                        <div class="col-8">
                                                                                            <div class="mb-3">
                                                                                                <label>Category</label>
                                                                                                <select name="category_id" id="" class="form-select">
                                                                                                    <option value="">-- Pilih Opsi --</option>
                                                                                                        @foreach ($categories as $category)
                                                                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                                        @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>                          
                                                                                    <div class="mb-3">
                                                                                        <label>Photo</label>
                                                                                        <input type="text" name="photo" class="form-control">
                                                                                    </div>
                                                                                    <div class="mb-3">
                                                                                        <label>Description</label>
                                                                                        <textarea name="description" class="form-control" ></textarea>
                                                                                    </div>                                                                
                                                                                </div>
                                                                            </div>
                                                                        </div>                                                   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>                                                      
                                        </div>
                                    </div>
                                    {{-- LIST PRODUKNYA --}}
                                    <div class="card-body">
                                        <div class="row row-cols-1 row-cols-md-3 g-4 ">
                                            @foreach ($products as $key => $product ) 
                                                <div class="col col-sm-12 ">  
                                                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                                                    <input type="hidden" value="{{ $product->price }}" name="price">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            {{ $product->name }}
                                                        </div>
                                                        <div class="card-body">
                                                            <div class=" d-flex justify-content-center align-items-center mb-3" style="height: 150px">
                                                                <img src="{{ $product->photo }}" style="width: 125px">
                                                            </div>
                                                            <div>{{ $product->description }}</div>
                                                            <div>Harga:  {{ rupiah($product->price) }} </div>
                                                            <div>Stock:  {{ $product->stock }} </div>
                                                            <div>Kategori:  {{ $product->category->name }} </div>
                                                        </div>                    
                                                        <div class="card-footer">  
                                                            <div class="row">    
                                                                {{-- Edit --}}
                                                                <div class="col">
                                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-{{$product->id}}" >
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </button>
                                                                    <form action="{{ route('product.update', $product) }}" method="POST">
                                                                        @csrf
                                                                        @method('put')
                                                                        <div class="modal fade" id="edit-{{$product->id}}" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        {{-- <input type="number" min="10000" class="form-control" value="10000" name="credit"> --}}
                                                                                        <div class="container">
                                                                                            <div class="row justify-content-center">                                                                                                       
                                                                                                <div>
                                                                                                    <div class="card">
                                                                                                        <div class="card-header">
                                                                                                            Edit Product
                                                                                                        </div>
                                                                                                        <div class="card-body">
                                                                                                                <div class="row">
                                                                                                                    <div class="col">
                                                                                                                        <div class="mb-3">
                                                                                                                            <label>Name</label>
                                                                                                                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" >
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="col">
                                                                                                                        <div class="mb-3">
                                                                                                                            <label>Price</label>
                                                                                                                            <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="row">
                                                                                                                    <div class="col-2">
                                                                                                                        <div class="mb-3">
                                                                                                                            <label>Stock</label>
                                                                                                                            <input type="number" name="stock" class="form-control" value="{{ $product->price }}">
                                                                                                                        </div>
                                                                                                                    </div>                                                                                                 
                                                                                                                    <div class="col-8">
                                                                                                                        <div class="mb-3">
                                                                                                                            <label>Category</label>
                                                                                                                            <select name="category_id" id="" class="form-select">
                                                                                                                                <option value="{{ $product->category_id }}">{{ $product->category->name }}</option>
                                                                                                                                @foreach ($categories as $category)
                                                                                                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>                          
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Photo</label>
                                                                                                                    <input type="text" name="photo" class="form-control" value="{{ $product->photo }}" >
                                                                                                                </div>
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Description</label>
                                                                                                                    <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                                                                                                                </div>                                                                
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>                                                   
                                                                                                </div>
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" >Submit</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    
                                                                </div>
                                                                {{-- Hapus --}}
                                                                <div class="col d-flex justify-content-end">
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $product->id }}">
                                                                        <i class="bi bi-trash3-fill"></i>
                                                                    </button>                                            
                                                                    <!-- Modal -->                                                                                        
                                                                    <div class="modal fade" id="delete-{{$product->id}}" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>                
                                                                            <form action="{{ route('product.destroy', $product->id )}}" method="POST">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <div class="modal-body text-start">Apakah anda yakin ingin menghapus {{ $product->name }} </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                          
                                                        </div>                                               
                                                    </div>              
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col">
                                <div class="card mt-1">
                                    <div class="card-header fw-bold fs-5">
                                        Riwayat Transaksi
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group border-0">   
                                            @foreach ($transactionAll as $key => $transaction)    
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <div class="row">
                                                            <div class="col fw-bold">
                                                                {{ $transaction[0]->order_id }}
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col text-secondary" style="font-size: 12px">
                                                                {{ $transaction[0]->created_at }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col d-flex justify-content-end align-items-center">
                                                        <a href="{{ route('download', ['order_id' => $transaction[0]->order_id]) }}" class="btn btn-primary">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    </div>
                                                </div>                                 
                                            @endforeach                                         
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
