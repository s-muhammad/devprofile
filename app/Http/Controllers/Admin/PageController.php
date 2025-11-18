<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => ['required','unique:pages,slug'],
            'text' => 'nullable',
            'image' => 'nullable',
        ]);
        if ($request->hasFile('image')) {
            $image = $this->uploader($request->file('image'), 'uploads/pages/');
        }
        Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'text' => $validated['text'],
            'image' => $image ?? null,
        ]);
        return redirect()->route('admin.page.index');
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
    public function edit(Page $page)
    {
        return view('admin.page.edit',compact('page'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
//            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug,' . $page->id],
            'text' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'banners.*.title' => 'required|string',
            'banners.*.image' => 'nullable|image',
        ]);
        $pageImage = $page->image;
        if ($request->hasFile('image')) {
            if ($page->image) {
                File::delete(public_path($page->image));
            }
            $pageImage = $this->uploader($request->file('image'), 'uploads/pages/');
        }
        $page->update([
            'title' => $data['title'],
            'text'  => $data['text'],
            'image' => $pageImage,
//            'slug'  => $data['slug'],
        ]);
        return redirect()->route('admin.page.index')->with('success', 'صفحه و بنرهای آن با موفقیت به‌روزرسانی شدند.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        File::delete($page->image);
        $page->delete();
        return redirect()->route('admin.page.index');
    }

    function uploader($file,$directory)
    {
        $fileName = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($directory);
        if ($file->move($destinationPath, $fileName)) {
            return $directory . $fileName;
        }
        return false;
    }
}
