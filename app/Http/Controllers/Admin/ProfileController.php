<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profile;

use App\ProfileHistory;

use Carbon\Carbon;

class ProfileController extends Controller
{
   public function add()
    {
        return view('admin.profile.create');
    }
    public function create(Request $request)
    {
        
        $this->validate($request, Profile::$rules);
        $profile = new Profile;
        $form = $request->all();
        unset($form['_token']);
        
        
        $profile->fill($form);
        $profile->save();
        
        return redirect('admin/profile/create');
    }
    public function edit(Request $request)
    {
       
         $profile_form = Profile::find($request->id);
        if(empty($profile_form)) {
            abort(404);
        }
        
        return view('admin.profile.edit',['profile_form' => $profile_form]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profile::$rules);
        $profile = Profile::find($request->id);
        $profile_form = $request->all();
        
        unset($profile_form['_token']);
        $profile->fill($profile_form)->save();
      
        
        $history = new ProfileHistory;
        $history->profile_id = $profile->id;
        $history->edited_at = Carbon::now(); 
        $history->save();
        
        return redirect(route('profile_edit', ['id'=>$profile->id]));
    }
}
