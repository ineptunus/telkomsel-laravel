@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Dashboard Analisis Kepuasan Pelanggan</h2>

    <div class="row mt-4">

        <div class="col-md-3">
            <div class="card p-3 shadow">
                <h5>Total Tweet</h5>
                <h2>{{ $totalTweet }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow">
                <h5>Positif</h5>
                <h2>{{ $positif }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow">
                <h5>Negatif</h5>
                <h2>{{ $negatif }}</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow">
                <h5>Sarkasme</h5>
                <h2>{{ $sarcasm }}</h2>
            </div>
        </div>

    </div>

</div>

@endsection