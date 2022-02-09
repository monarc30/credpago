@extends('layouts.app')

@section('content')    

    <h2 class="text-3xl font-extrabold text-gray-600">Links</h2>  
    
    @if (session()->has('message'))
        <div class="w-4/5 m-auto mt-10 pl-2">
            <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
                {{ session()->get('message') }}
            </p>            
        </div>        
    @endif

    @if (Auth::check())
        <div class="pt-15 w-4/5 m-auto">
            <a href="/site/create" class="bg-blue-500 uppercase bg-transparent text-gray-100 text-xs font-extrabold py-3 px-5 rounded-3xl">
                Insert Site
            </a>
        </div>
    @endif

    @foreach ($sites as $site)

        <div class="pt-15 w-4/5 m-auto">
            <div class="m-auto sm:m-auto text-left w-4/5 block">                                    
                {{ $site->url }}            
            </div>
            <div class="m-auto sm:m-auto text-left w-4/5 block">
                {{ $site->status_code }}                
            </div>
            <div class="m-auto sm:m-auto text-left w-4/5 block">
                {{ $site->user->name }}
            </div>
            <div class="m-auto sm:m-auto text-left w-4/5 block">
                {{ $site->updated_at }}
            </div>

            <a href="/site/{{ $site->id }}" class="uppercase bg-blue-500 text-gray-100 text-lg font-extrabold py-4 px-8 rounded-3xl">
                Detalhes
            </a>
            
            @if (isset(Auth::user()->id) && Auth::user()->id === $site->user_id)
                <span class="float-right">
                    <a 
                        href="/site/{{ $site->id }}/edit"
                        class="text-gray-700 italic hover:text-gray-900
                        pb-1 border-b-2"
                    >Editar
                    </a>
                </span>

                <span class="float-right">
                    <form 
                        action="/site/{{ $site->id }}"
                        method="POST">
                        @csrf
                        @method('delete')

                        <button
                            class="text-red-500 pr-3"
                            type="submit"
                            >Excluir
                        </button>
                    </form>
                </span>
            @endif
        </div>
        
    @endforeach

    
@endsection