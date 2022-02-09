@extends('layouts.app')

@section('content')    

<div class="w-4/5 m-auto text-left">
    <div class="py-15">
        <h2 class="text-3xl font-extrabold text-gray-600">Insert Link</h2>               
    </div>
</div>

@if ($errors->any())
    <div class="w-4/5 m-auto">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="w-1/5 mb-4 text-gray-50 bg-red-700 rounded-2xl py-4">
                    {{ $error }}
                </li>                
            @endforeach            
        </ul>         
    </div>
@endif


<div class="w-4/5 m-auto pt-20">
    <form action="/site" method="POST">
        @csrf

        <input 
            type="text"
            name="url"
            placeholder="Digite a url"
            class="bg-gray-0 block border-b-2 w-full h-20 text-6xl outline-none"
        >
        
        <button 
            type="submit"
            class="uppercase mt-15 bg-blue-500 text-gray-100 text-lg
            font-extrabold py-4 px-8 rounded-3xl">
            Submit Post
        </button>
    </form>    
</div>

@endsection