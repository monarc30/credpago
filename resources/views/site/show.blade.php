@extends('layouts.app')

@section('content')    

<div class="w-4/5 m-auto text-left">
    <div class="py-15">
        <h2 class="text-3xl font-extrabold text-gray-600">{{ $site->url }}</h2>               
    </div>
</div>

<div class="w-4/5 m-auto pt-20">
    <span class="text-gray-500">
        <strong>{{ $site->status_code_first }}</strong>
    </span>
    <br />
    <br />

    <span class="text-gray-500">
        {{ $site->status_code_last }}
    </span>

    <span class="text-gray-400">
        @php
            $explode = explode( ";", $site->obs );    
            for ($i=0; $i<count($explode); $i++) {
                echo $explode[$i].'<br>';
            }
        @endphp
    </span>
</div>

@endsection