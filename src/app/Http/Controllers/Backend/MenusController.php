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

class MenusController extends BaseController
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
    
    
    public function getMainmenu()
    {
        $menus = Menu::where('menutype', "Mainmenu")->where('submenuof', '0')->where('active', '1')->orderby('position', 'asc')->get();
        if ($menus) {
            $mainmenu = [];
            $x = 0;
            foreach ($menus as $mm) {
                $mainmenu[$x]['menustring'] = $mm->menustring;
                $mainmenu[$x]['menuurl'] = $mm->menuurl;
                $submenus = Menu::where('menutype', "Mainmenu")->where('submenuof', $mm->id)->where('active', '1')->orderby('position', 'asc')->get();
                if (!empty($submenus)) {
                    $mainmenu[$x]['submenus'] = $submenus->toArray();
                }
                $x++;
            }
        }
        echo '<pre>';
        print_r($mainmenu);
        echo '</pre>';
        die();
        //return $mainmenu;
    }
    
    public function index()
    {
        $menus = Menu::paginate(10);
        return view('backend.menus.list', [
            'menus' => $menus
        ]);
    }
    
    // GET
    public function show($id, Request $request)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return view('backend.menus.list', [
                'errors' => ['message' => 'Menu does not exist']
            ], 404);
        }
        return view('backend.menus.show', [
            'menu' => $menu,
        ]);
    }
    
    
    // POST
    public function store(Request $request)
    {
        $request->flash();
        $mainmenus = Menu::where('menutype', "mainmenu")->where('submenuof', '0')->get();
        if ($request->isMethod('POST') && $request->has('menustring')) {
             //'menutype', 'position', 'submenuof', 'menustring', 'menuurl', 'active'
            $rules = [
                        'menutype' => 'required|in:Mainmenu',
                        'position' => 'required|numeric',
                        'submenuof' => '',
                        'menustring' => 'required|max:25|unique:menus,menustring',
                        'menuurl' => 'required|max:255|unique:menus,menuurl',
                    ];
            
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.menus.store', [
                    'mainmenus' => $mainmenus,
                    'errors'=>$validator->errors(),
                ]);
            }
            
            $menu = new Menu;
            $menu->menustring = $request->menustring;
            $menu->menuurl = preg_replace("/[^A-Za-z0-9\-\_]/", '', str_replace(" ", "_", strtolower(isset($request->menuurl)?$request->menuurl:$request->menustring)));
            $menu->menutype = ($request->has('menutype')?$request->menutype:"mainmenu");
            $menu->submenuof = ($request->has('submenuof')?$request->submenuof:0);
            $menu->position = ($request->has('position')?$request->position:0);
            $menu->active = ($request->has('active')?$request->active:0);
            $menu->save();

            return redirect('/admin/menus')->with('success', 'New menu successfully created!');
        } else {
            return view('backend.menus.store', [
                    'mainmenus' => $mainmenus,]);
        }
    }
    
    
    // PATCH/PUT
    public function update($id, Request $request)
    {
        $request->flash();
        $menu = Menu::find($id);
        $mainmenus = Menu::where('menutype', "mainmenu")->where('submenuof', '0')->get();
        
        if (!$menu) {
            return view('backend.menus.list', [
                'errors' => ['message' => 'Menu does not exist']
            ], 404);
        }

        if ($request->isMethod('PATCH') && $request->has('menustring')) {
            $rules = [
                        'menutype' => 'required|in:Mainmenu',
                        'position' => 'required|numeric',
                        'submenuof' => '',
                        'menustring' => 'required|max:25|unique:menus,menustring,'.$id,
                        'menuurl' => 'required|max:255|unique:menus,menuurl,'.$id,
                    ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return view('backend.menus.update', [
                    'menu' => $menu,
                    'mainmenus' => $mainmenus,
                    'errors'=>$validator->errors(),
                ]);
            }


            try {
                $menu->menustring = ($request->has('menustring')?$request->menustring:$menu->menustring);
                $menu->menuurl = preg_replace("/[^A-Za-z0-9\-\_]/", '', str_replace(" ", "_", strtolower(isset($request->menuurl)?$request->menuurl:($request->menustring == ''?$menu->menustring:$request->menustring))));
                $menu->menutype = ($request->has('menutype')?$request->menutype:$menu->menutype);
                $menu->submenuof = ($request->has('submenuof')?$request->submenuof:0);
                $menu->position = ($request->has('position')?$request->position:0);
                $menu->active = ($request->has('active')?$request->active:0);
                $menu->save();
                
                return redirect('/admin/menus/'.$id)->with('success', 'Menu content updated!');
            } catch (Exception $e) {
                return view('backend.menus.update', [
                    'menu' => $menu,
                    'mainmenus' => $mainmenus,
                    'errors' => [
                        'message' => 'Faliure in update [Exception]'
                    ]
                ]);
            }
        } else {
            return view('backend.menus.update', [
                'menu' => $menu,
                'mainmenus' => $mainmenus,
            ]);
        }
    }
    
    
    // Change active by AJAX
    public function activate($id, Request $request)
    {
        if ($request->ajax()) {
            $menu = Menu::find($id);
            $menu->active = $request->input('active');
            $menu->save();
            return Response::json([
                        'data' => $request->input('active')
                    ], 200);
        }
    }

    
    // DELETE
    public function destroy($id, Request $request)
    {
        Menu::findOrFail($id)->delete();
        return redirect('/admin/menus')->with('success', 'Menu details deleted!');
    }
}
