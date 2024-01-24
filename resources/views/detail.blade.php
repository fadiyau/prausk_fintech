@extends('layouts.app')

@php
    function rupiah($angka){
        $hasil_rupiah = "Rp" . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">                               
                                    e-Receipt #{{ $transactions[0]->order_id }}
                                </div>
                                <span class="text-secondary">{{ $transactions[0]->created_at }}</span>
                            </div>
                            <div class="card-body">
                                @foreach ($transactions as $transaction)
                                    <div class="row" style="font-size: 15px">
                                        <div class="col">
                                            {{ $transaction->product->name }}
                                        </div>
                                        <div class="col">
                                            {{ $transaction->quantity }} *
                                        </div>
                                        <div class="col">
                                            {{ rupiah($transaction->price) }}                                   
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer px-5">                            
                                <div class="row">
                                    <div class="col d-flex justify-content-start">
                                        Total:
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        {{ rupiah($total_biaya) }}
                                    </div>
                                </div>                           
                            </div>
                        </div>
                        <script>
                            window.print();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection