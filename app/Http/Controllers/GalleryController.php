<?php

namespace App\Http\Controllers;

use App\Models\Gallery;

use Illuminate\Http\Request;
use  App\Http\Resources\GalleryResource;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use Illuminate\Support\Facades\Storage;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galleryQuery = Gallery::search($request);
        
        return inertia('Gallery/Index', [
            'gallerys' => GalleryResource::collection(
                $galleryQuery->paginate(10)
            ),
             
            'search' => request('search') ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        return inertia('Gallery/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        //dd($request);
       // Gallery::create($request->validated());

        
         

        $file = $request->file('image_url');
        $path = $file->store('gallery', 'public');
        Gallery::insert([
                'image_url' => $path,
                'title' => $request->title,
                'description' => $request->description,
        ]);
        return redirect()->route('gallerys.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        return inertia('Gallery/Edit', [
            'gallery' => GalleryResource::make($gallery),
             
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //dd
       // dd($request);
       if($request->hasFile('image_url')){
        $file = $request->file('image_url');
        $path = $file->store('gallery', 'public');
       }
       else{
        $path=$request->image_url;
       }
        Gallery::where('id',$gallery->id)->update([
                'image_url' => $path,
                'title' => $request->title,
                'description' => $request->description,
        ]);
        return redirect()->route('gallerys.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('gallerys.index');
    }
}
