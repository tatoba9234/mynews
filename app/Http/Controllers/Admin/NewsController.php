<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;

class NewsController extends Controller
{
    
    public function add()
    {
        return view('admin.news.create');
    }
    
    public function create(Request $request)
    {
        $this->validate($request, News::$rules);
        
        $news = new News;
        $form = $request->all();
        
        if (isset($form['image'])) {
            $path =$request->file('image')->store('public/image');
        } else {
            $news->image_path = null;
        }
        
        unset($form['_token']);
        
        unset($form['_image']);
        
        $news->fill($form);
        $news->save();
        
        return redirect('admin/news/create');
    }
    
    
}
