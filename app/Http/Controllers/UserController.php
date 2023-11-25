<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('skills')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('users.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|max:50',
            'password' => 'required|string|max:50',
            'another_skills' => 'string'
        ]);

        
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

    // validation passed
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        $user->skills()->attach($request->input('skills'));
        // $user isntanca od modelot user 
        // skils() e relacijata belongstoMAny so se korsiti za da imam pristap do skills
        // 

       // Save additional skills
        $anotherSkills = $request->input('another_skills');
        if ($anotherSkills) {
            $additionalSkills = explode(',', $anotherSkills);
            foreach ($additionalSkills as $additionalSkill) {
                $user->skills()->create(['name' => trim($additionalSkill)]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User is succesfully created.');
    }

   



}
