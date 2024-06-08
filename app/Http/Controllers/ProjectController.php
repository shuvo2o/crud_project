<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function Index()
    {
        $projects = Project::with('skill')->get();
        
        return Inertia::render('Project/Index',compact('projects'));
    }

    public function ProjectCreate()
    {
        $skills = Skill::all();
        // dd($skills);
        return Inertia::render('Project/Create',  compact('skills'));
    }

    public function ProjectStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image'],
            'name' => ['required', 'min:3'],
            'skill_id' => ['required', 'min:1'],
            'project_url' => ['required', 'min:3'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if ($request->hasFile('image')) {
            $proejct_image = $request->file('image');
            $uniqueName = time() . '-' . Str::random(10) . '.' . $proejct_image->getClientOriginalExtension();
            $proejct_image->move('project_images', $uniqueName);

            Project::create([
                'name' => $request->name,
                'skill_id' => $request->skill_id,
                'project_url' => $request->project_url,
                'image' => 'project_images/' . $uniqueName,
            ]);
            return Redirect::route('project.index')->with('message', 'Project created successfully.');
        }

        return Redirect::back();
    }


    public function ProjectEdit(Project $project)
    {
        $skills = Skill::all();
        return Inertia::render('Project/Edit', compact('skills', 'project'));
    }


    public function ProjectUpdate(Request $request, Project $project) {
        $request->validate([
            'name' => ['required', 'min:3'],
            'skill_id' => ['required', 'min:1'],
        ]);
    
        $image = $project->image;
    
        if ($request->hasFile('image')) {
            if ($project->image && file_exists(public_path($project->image))) {
                unlink(public_path($project->image));
            }
    
            $imageFile = $request->file('image');
            $uniqueName = time() . '-' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('project_images'), $uniqueName);
    
            $image = 'project_images/' . $uniqueName;
        }
    
        $project->update([
            'name'=> $request->name,
            'skill_id'=> $request->skill_id,
            'project_url'=> $request->project_url,
            'image'=> $image,
        ]);
    
        return Redirect::route('project.index')->with('message', 'Project Updated successfully');
    }
    
  
  
    public function ProjectDelete( Project $project){
  
     $image = $project->image;
     if (File::exists($image)) {
         File::delete($image);
     }
     $project->delete();
     return Redirect::route('project.index')->with('message', 'Project Deleted succesfully');
    }
  
}
