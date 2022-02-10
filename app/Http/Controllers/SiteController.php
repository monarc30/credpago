<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Site;
use Illuminate\Http\Request;
use GuzzleHttp\RetryMiddleware;

class SiteController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site.index')->with('urls', Site::orderBy('updated_at', 'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);        

        $url = $request->input('url');
        
        // echo '<pre>';
        // print_r(get_headers($url));        
        // echo '</pre>';
        // exit;

        try {
            
            $response = get_headers($url);

            $obs = "";
            
            for ($i=0; $i<count($response); $i++) {
                $obs .= $response[$i].";";
            }
            
            Site::create([
                'url' => $request->input('url'),
                'status_code_first' => $response[0],
                'status_code_last' => $response[7],
                'user_id' => auth()->user()->id,           
                'obs' => $obs
            ]);

        } catch (Exception $e) {            
            return redirect('/site')
            ->with('message', 'URL inválida!');

        }        

        return redirect('/site')
            ->with('message', 'URL inserida com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('site.show')
            ->with('site', Site::where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('site.edit')
            ->with('site', Site::where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required'
        ]);     
        
        Site::where('id', $id)
            ->update([
                'url' => $request->input('url'),                
                'user_id' => auth()->user()->id,           
            ]);
        
        return redirect('/site')
            ->with('message', 'Url alterada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::where('id', $id);
        $site->delete();

        return redirect('/site')
            ->with('message', 'Url excluída!');
    }

    public function updateUrlStatus() 
    {
        $urls = Site::all();

        foreach ($urls as $row) {            

            $response = get_headers($row['url']);

            $obs = "";

            for ($i=0; $i<count($response); $i++) {
                $obs .= $response[$i].";";
            }

            if (isset($response[0]) && isset($response[7])) {

                $url = Site::find($row['id']); 
                $url->url = $row['url']; 
                $url->status_code_first = $response[0]; 
                $url->status_code_last = $response[1];                 
                $url->obs = $obs;
                $url->save(); 
                
            }                            
        }        
    }
}
