<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.service.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'summary' => 'required',
        ]);
        $image = $this->uploader($request->file('image'));
        Service::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $image,
            'summary' => $data['summary'],
        ]);
        return redirect()->route('admin.service.index');
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
    public function edit(Service $service)
    {
        return view('admin.service.edit',compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'summary' => 'required',
        ]);
        if($request->file('image')){
            File::delete($service->image);
            $image = $this->uploader($request->file('image'));
        }
        $service->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $image ?? $service->image,
            'summary' => $data['summary'],
        ]);
        return redirect()->route('admin.service.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        File::delete($service->image);
        $service->delete();
        return redirect()->route('admin.service.index');
    }

    function uploader($file)
    {
        $path = 'uploads/services/';
        $fileName = time().'.'.$file->getClientOriginalExtension();
        $file->move($path,$fileName);
        return $path.$fileName;
    }
}
