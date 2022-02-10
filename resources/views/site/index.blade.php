@extends('layouts.app')

@section('content')    

    <h2 class="text-3xl font-extrabold text-gray-600">URLs</h2>  
    
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

    <div class="pt-15 w-4/5 m-auto">
        <table class="styled-table">
            <thead>
                <tr>
                  <th>Url</th>
                  <th>Status Code</th>
                  <th>User</th>
                  <th>Data</th>
                  <th>Detalhes</th>
                  <th colspan=2>Operação</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($urls as $url)
                
                    <tr>
                        <td>
                            {{ $url->url }}                       
                        </td>
                    
                        <td>
                            {{ $url->status_code_first }} ----->  {{ $url->status_code_last }} 
                        </td>            
                    
                        <td>
                            {{ $url->user->name }}
                        </td>
                    
                        <td>
                            {{ $url->updated_at }}
                        </td>                

                        <td>
                            <a href="/site/{{ $url->id }}">
                                Detalhes
                            </a>
                        </td>
                    
                        @if (isset(Auth::user()->id) && Auth::user()->id === $url->user_id)
                            <td>
                                <span class="float-right">
                                    <a 
                                        href="/site/{{ $url->id }}/edit"
                                        class="text-gray-700 italic hover:text-gray-900
                                        pb-1 border-b-2"
                                    >Editar
                                    </a>
                                </span>
                            </td>

                            <td>
                                <span class="float-right">
                                    <form 
                                        action="/site/{{ $url->id }}"
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
                            </td>
                        @endif       
                    
                    </tr>

                @endforeach
            
            </tbody>

        </table>
    </div>

    
@endsection