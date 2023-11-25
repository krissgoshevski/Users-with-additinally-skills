<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;

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

    public function store(UserRequest $request)
    {
    

        // Validation passed
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->skills()->attach($request->input('skills'));

        // Save additional skills
        $anotherSkills = $request->input('another_skills');
        if ($anotherSkills) {
            $additionalSkills = explode(',', $anotherSkills);
            foreach ($additionalSkills as $additionalSkill) {
                $user->skills()->create(['name' => trim($additionalSkill)]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User is successfully created.');
    }


    


    public function indexApi()
    {
        $users = User::with('skills')->get();

        return response()->json(['users'=> $users]);
    }

    public function storeApi(UserRequest $request)
    {

        // Validation passed
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->skills()->attach($request->input('skills'));

        // Save additional skills
        $anotherSkills = $request->input('another_skills');
        if ($anotherSkills) {
            $additionalSkills = explode(',', $anotherSkills);
            foreach ($additionalSkills as $additionalSkill) {
                $user->skills()->create(['name' => trim($additionalSkill)]);
            }
        }

        // Return success response
        return $this->getSuccessResponse('User is successfully created.', $user);
    }

        


        public function destroy(string $id) 
        {

            $user = User::findOrFail($id);
            $user = User::destroy($id);

            return response()->json([ 
                'message'=> 'User deleted sucesfully',
            ]);
        }





        public function updateApi(Request $request, $id)
        {
                $user = User::find($id);

                // Check if the user exists
                if (!$user) {
                    return $this->getErrorResponse('User not found.', 404);
                }

                // Update only the fields that are present in the request
                $user->update($request->only(['name', 'email', 'password', 'another_skills']));
                $user->skills()->sync($request->input('skills'));

                // Update additional skills
                $anotherSkills = $request->input('another_skills');
                if ($anotherSkills) {
                    $additionalSkills = explode(',', $anotherSkills);
                    foreach ($additionalSkills as $additionalSkill) {
                        $user->skills()->update(['name' => trim($additionalSkill)]);
                    }
                }

                // Return success response
                return $this->getSuccessResponse('User is successfully updated.', $user);
        }

        




    private function getErrorResponse($message, $status)
    {
        return response()->json(['error' => $message], $status);
    }

    private function getSuccessResponse($message, $user)
    {
        return response()->json([
            'message' => $message,
            'user' => $user ], 200);
    }


}
