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
    <div class="card mb-3 ">
        <div class="card-header fw-bold fs-5">
            <div>
                Riwayat Transaksi
            </div>
            <a href="/home" style="font-size: small;">Kembali</a>
        </div>
        <div class="card-body">
            <ul class="list-group border-0">                                            
                @foreach ($mutasiAll as $data)
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
@endsection