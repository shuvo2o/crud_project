<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class SkillController extends Controller
{
    public function Index()
    {
        
        $skills = Skill::all();

        return Inertia::render('Skill/Index', ['skills' => $skills]);
    }
    public function SkillCreate()
    {
        return Inertia::render('Skill/Create');
    }

    public function SkillStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image'],
            'name' => ['required', 'min:3'],
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move('skill_images', $uniqueName);


            Skill::create([
                'name' => $request->name,
                'image' => 'skill_images/' . $uniqueName
            ]);
            return Redirect::route('skill.index')->with('success', 'Skill Created succesfully');
        }
        return Redirect::back();
    }

    public function SkillEdit(Skill $skill)
    {
        return Inertia::render('Skill/Edit', [
            'skill' => $skill,
        ]);
    }

    public function SkillUpdate(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
        ]);

        $image = $skill->image;

        if ($request->hasFile('image')) {

            if ($skill->image && file_exists(public_path($skill->image))) {
                unlink(public_path($skill->image));
            }


            $image = $request->file('image');
            $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('skill_images'), $uniqueName);


            $image = 'skill_images/' . $uniqueName;
        }


        $skill->update([
            'name' => $request->name,
            'image' => $image
        ]);


        return Redirect::route('skill.index');
    }

    public function SkillDelete(Skill $skill)
    {
        $image = $skill->image;
        if (File::exists($image)) {
            File::delete($image);
        }

        $skill->delete();
        return Redirect::route('skill.index');
    }

    
}
