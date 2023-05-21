<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Response;
use Validator;
use Cache;
use App\Page;
use App\Menu;

class PagesController extends BaseController
{
    
    public $_limit = 10;
    //use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    
    public function index()
    {
        return view('backend.dashboard', [
            'name' => "Welcome Backend"
        ]);
    }

    
    public function pages()
    {
        $pages = Page::paginate(10);
        return view('backend.pages.list', [
            'pages' => $pages
        ]);
    }
    
    // GET
    public function show($id, Request $request)//, AgentuserRepository $agtuserrepo, $id)
    {
        $page = Page::with('menu')->find($id);
        if (!$page) {
            return view('backend.pages.list', [
                'errors' => ['message' => 'Page does not exist']
            ], 404);
        }
        return view('backend.pages.show', [
            'page' => $page,
        ]);
    }
    
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        $mainmenus = $this->getMainmenu();
        if ($request->isMethod('POST') && $request->has('title')) {
            $rules = [
                        'title' => 'required|max:255|unique:pages,title',
                        'url' => 'required_without:menu_id|max:255|unique:pages,url',
                        'menu_id' => 'required_without:url',
                        'content' => 'required',
                    ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.pages.store', [
                    'mainmenus' => $mainmenus,
                    'errors'=>$validator->errors(),
                ]);
            }
            
            $page = new Page;
            $page->title = $request->title;
            $page->url = preg_replace("/[^A-Za-z0-9\-\_]/", '', str_replace(" ", "_", strtolower(isset($request->url)?$request->url:$request->title)));
            $page->content = $request->content;
            $page->menu_id = ($request->has('menu_id')?$request->menu_id:0);
            $page->active = ($request->has('active')?$request->active:0);
            $page->save();

            return redirect('/admin/pages')->with('success', 'New page successfully created!');
        } else {
            return view('backend.pages.store', ['mainmenus' => $mainmenus]);
        }
    }
    
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $page = Page::find($id);
        $mainmenus = $this->getMainmenu();
        if (!$page) {
            return view('backend.pages.list', [
                'errors' => ['message' => 'Page does not exist']
            ], 404);
        }

        if ($request->isMethod('PATCH') && $request->has('title')) {
            $rules = [
                        'title' => 'required|max:255|unique:pages,title,'.$id,
                        'url' => 'required_without:menu_id|max:255|unique:pages,url,'.$id,
                        'menu_id' => 'required_without:url',
                        'content' => 'required',
                    ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.pages.update', [
                    'page' => $page,
                    'mainmenus' => $mainmenus,
                    'errors'=>$validator->errors(),
                ]);
            }


            try {
                $page->title = ($request->title?$request->title:$page->title);
                $page->url = preg_replace("/[^A-Za-z0-9\-\_]/", '', str_replace(" ", "_", strtolower(isset($request->url)?$request->url:($request->title == ''?$page->title:$request->title))));
                $page->content = ($request->has('content') && $request->content != ''?$request->content:$page->content);
                $page->menu_id = ($request->has('menu_id')?$request->menu_id:$page->menu_id);
                $page->active = ($request->has('active')?$request->active:0);
                $page->save();
                
                return redirect('/admin/pages/'.$id)->with('success', 'Page content updated!');
            } catch (Exception $e) {
                return view('backend.pages.update', [
                    'page' => $page,
                    'mainmenus' => $mainmenus,
                    'errors' => [
                        'message' => 'Faliure in update [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.pages.update', [
                'page' => $page,
                'mainmenus' => $mainmenus
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $page = Page::find($id);
            $page->active = $request->input('active');
            $page->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }

    
    // DELETE
    public function destroy($id, Request $request)
    {
        Page::findOrFail($id)->delete();
        return redirect('/admin/pages')->with('success', 'Page details deleted!');
    }
    
    
    public function getMainmenu()
    {
        $menus = Menu::where('menutype', "Mainmenu")->where('submenuof', '0')->where('active', '1')->orderby('position', 'asc')->get();
        if ($menus) {
            $mainmenu = [];
            $x = 0;
            foreach ($menus as $mm) {
                $mainmenu[$x]['id'] = $mm->id;
                $mainmenu[$x]['menustring'] = $mm->menustring;
                $mainmenu[$x]['menuurl'] = $mm->menuurl;
                $submenus = Menu::where('menutype', "Mainmenu")->where('submenuof', $mm->id)->orderby('position', 'asc')->get();
                $submenus = $submenus->toArray();
                //echo '<pre>'; print_r($submenus); echo '</pre>';die();
                if (isset($submenus[0]['id'])) {
                    foreach ($submenus as $sm) {
                        $x++;
                        $mainmenu[$x]['id'] = $sm['id'];
                        $mainmenu[$x]['menustring'] = $mm->menustring.' > '.$sm['menustring'];
                        $mainmenu[$x]['menuurl'] = $sm['menuurl'];
                    }
                }
                $x++;
            }
        }
        //echo '<pre>'; print_r($mainmenu); echo '</pre>';die();
        return $mainmenu;
    }
}
