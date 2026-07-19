<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Projects::latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'url' => 'nullable',
            'is_featured' => 'nullable',
        ]);
        $image = $this->uploader($request->file('image'));
        if ($request->has('is_featured') && $request->is_featured == 1) {
            Projects::where('is_featured', 1)->update(['is_featured' => 0]);
        }
        Projects::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'image' => $image,
            'url' => $request['url'],
            'is_featured' => $request['is_featured'],
        ]);
        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projects $project)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'url' => 'nullable',
            'is_featured' => 'nullable',
        ]);
        $image = $project->image;
        if ($request->file('image')) {
            File::delete($image);
            $image = $this->uploader($request->file('image'));
        }
        if ($request->has('is_featured') && $request->is_featured == 1) {
            Projects::where('is_featured', 1)->update(['is_featured' => 0]);
        }
        $project->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $image,
            'url' => $data['url'],
            'is_featured' => $data['is_featured'],
        ]);
        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Projects $project)
    {
        File::delete($project->image);
        $project->delete();
        return redirect()->route('admin.projects.index');
    }

    function uploader($file)
    {
        $path = 'uploads/projects/';
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move($path, $filename);
        return $path . $filename;
    }
}
