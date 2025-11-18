<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'page_id' => 'required',
            'title' => 'required',
            'image' => 'required',
            'link' => 'nullable',
            'position' => 'nullable',
            'text' => 'nullable',
            'label' => 'nullable',
        ]);
        $image = $this->uploader($data['image']);
        Banner::create([
            'page_id' => $data['page_id'],
            'title' => $data['title'],
            'image' => $image,
            'link' => $data['link'],
            'position' => $data['position'],
            'text' => $data['text'],
            'label' => $data['label'],
        ]);
        return redirect()->route('admin.banner.index');
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
    public function edit(Banner $banner)
    {
        $pages = Page::all();
        return view('admin.banner.edit', compact('banner', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'page_id' => 'required',
            'title' => 'required',
            'image' => 'nullable',
            'link' => 'nullable',
            'position' => 'nullable',
            'text' => 'nullable',
            'label' => 'nullable',
        ]);
        $image = $banner->image;
        if ($request->hasFile('image')) {
            File::delete($image);
            $image = $this->uploader($data['image']);

        }
        $banner->update([
            'page_id' => $data['page_id'],
            'title' => $data['title'],
            'image' => $image,
            'link' => $data['link'],
            'position' => $data['position'],
            'text' => $data['text'],
            'label' => $data['label'],
        ]);
        return redirect()->route('admin.banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        File::delete($banner->image);
        $banner->delete();
        return redirect()->route('admin.banner.index');
    }

    function uploader($image)
    {
        $path = 'uploads/banners/';
        $file = rand() . '.' . $image->getClientOriginalExtension();
        $image->move($path, $file);
        return $path . $file;
    }
}
