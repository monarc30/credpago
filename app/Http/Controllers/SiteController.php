<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\RetryMiddleware;
use App\Repositories\Contracts\SiteRepositoryInterface;


class SiteController extends Controller
{
    
    protected $model;

    public function __construct(SiteRepositoryInterface $model)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        
        $this->model = $model;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = $this->model; 
        return view('site.index')->with('urls', $model->orderBy('updated_at', 'DESC')->get());
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
        $model = $this->model;
        
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
            
            $model->create([
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
        $model = $this->model; 
        
        return view('site.show')
            ->with('site', $model->where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->model; 
        
        return view('site.edit')
            ->with('site', $model->where('id', $id)->first());
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

        $model = $this->model; 
        
        $request->validate([
            'url' => 'required'
        ]);     
        
        $model->where('id', $id)
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
        $model = $this->model; 
        
        $site = $model->where('id', $id);
        $site->delete();

        return redirect('/site')
            ->with('message', 'Url excluída!');
    }

    public function updateUrlStatus() 
    {
        
        $model = $this->model;

        $urls = $model->all();
        
        foreach ($urls as $row) {            

            $response = get_headers($row['url']);

            $obs = "";

            for ($i=0; $i<count($response); $i++) {
                $obs .= $response[$i].";";
            }

            if (isset($response[0]) && isset($response[7])) {

                $url = $model->find($row['id']); 
                $url->url = $row['url']; 
                $url->status_code_first = $response[0]; 
                $url->status_code_last = $response[1];                 
                $url->obs = $obs;
                $url->save();                 
            }                            
        }
        
        return true;
    }
}
