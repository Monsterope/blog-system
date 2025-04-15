<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogCreateRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Resources\BlogContentResource;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cache::rememberForever("blogs", function(){
            return BlogResource::collection(Blog::orderBy('created_at', 'desc')->get());
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {
        $blog = Blog::create([
            'title' => $request->title,
            'contents' => $request->contents,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);
        Cache::forget("blogs");
        return response()->json([
            'blog' => $blog,
        ], HttpResponse::HTTP_CREATED);
        // $photo = [];

        // if ($request->hasFile('image')) {
        //     foreach ($request->file('image') as $file) {
        //         $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        //         $path = $file->storeAs('uploads', $filename, 'public');
        //         $url = Storage::disk('public')->url($path);

        //         // แทรกรูปลงในเนื้อหาแบบ markdown
        //         $content .= "\n\n![image]($url)";

        //         $photo[] = [
        //             'filename' => $file->getClientOriginalName(),
        //             'url' => $url,
        //             'path' => $path,
        //             'mime_type' => $file->getMimeType(),
        //             'size' => $file->getSize(),
        //         ];
        //     }
        // }

        // // บันทึกรูปทั้งหมดที่เกี่ยวข้อง
        // foreach ($photo as $img) {
        //     $img["blog_id"] = $blog->id;
        //     $blog->photo()->create($img);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogList = Cache::get("blogs");
        $blog = !$blogList ? Blog::where('id', $id)->first() : collect($blogList)->where('id', $id)->first();
        if ($blog == null) {
            return response()->json(["data" => null]);
        }
        return new BlogContentResource($blog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->update([
            'title' => $request->title,
            'contents' => $request->contents,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);
        Cache::forget("blogs");
        return response()->json(new BlogContentResource($blog));

        // // 1. ลบรูปที่ผู้ใช้ต้องการลบ
        // if ($request->filled('remove_image_ids')) {
        //     foreach ($request->remove_image_ids as $imgId) {
        //         $img = $blog->photo()->where('id', $imgId)->first();
        //         if ($img) {
        //             Storage::disk('public')->delete($img->path);
        //             $img->delete();
        //         }
        //     }
        // }
        // $photo = [];

        // if ($request->hasFile('image')) {
        //     foreach ($request->file('image') as $file) {
        //         $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        //         $path = $file->storeAs('uploads', $filename, 'public');
        //         $url = Storage::disk('public')->url($path);

        //         // แทรกรูปลงในเนื้อหาแบบ markdown
        //         $content .= "\n\n![image]($url)";

        //         $photo[] = [
        //             'filename' => $file->getClientOriginalName(),
        //             'url' => $url,
        //             'path' => $path,
        //             'mime_type' => $file->getMimeType(),
        //             'size' => $file->getSize(),
        //         ];
        //     }
        // }

        // บันทึกรูปทั้งหมดที่เกี่ยวข้อง
        // foreach ($photo as $img) {
        //     $img["blog_id"] = $blog->id;
        //     $blog->photo()->create($img);
        // }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Blog::where('id', $id)->delete();
        Cache::forget("blogs");
        return response()->json(["message"], HttpResponse::HTTP_NO_CONTENT);
    }

    public function Upload(UploadRequest $request){
        
        $file = $request->file('image');
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $filename, 'public');
        $url = Storage::disk('public')->url($path);
        return response()->json(["url" => $url]);
        // $photo = [
        //     'filename' => $file->getClientOriginalName(),
        //     'url' => $url,
        //     'path' => $path,
        //     'mime_type' => $file->getMimeType(),
        //     'size' => $file->getSize(),
        // ];
        // Photo::create($photo);

        // $path = $request->file('file')->store('uploads', 'public');
        // $url = asset('storage/' . $path);

        // $photo[] = [
        //     'filename' => $file->getClientOriginalName(),
        //     'url' => $url,
        //     'path' => $path,
        //     'mime_type' => $file->getMimeType(),
        //     'size' => $file->getSize(),
        // ];
        // if ($request->hasFile('image')) {
        //     foreach ($request->file('image') as $file) {
        //         $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        //         $path = $file->storeAs('uploads', $filename, 'public');
        //         $url = Storage::disk('public')->url($path);

        //         // แทรกรูปลงในเนื้อหาแบบ markdown
        //         $content .= "\n\n![image]($url)";

        //         $photo[] = [
        //             'filename' => $file->getClientOriginalName(),
        //             'url' => $url,
        //             'path' => $path,
        //             'mime_type' => $file->getMimeType(),
        //             'size' => $file->getSize(),
        //         ];
        //     }
        // }
    }
}
