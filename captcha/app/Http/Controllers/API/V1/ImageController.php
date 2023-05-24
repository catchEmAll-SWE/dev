<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Http\Resources\V1\ImageResource;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ImageResource::collection(Image::all());
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
    public function store(StoreImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
    
    public function getClasses() {
        return Image::select('class')->distinct()->pluck('class');
    }

    public function getCaptchaClasses(int $num_of_classes) : array {
        return Image::select('class')->distinct()->inRandomOrder()->limit($num_of_classes)->pluck('class')->toArray();

    }

    public function updateReliability(string $id, int $reliability) : void {
        Image::where('id', $id)->update(['reliability' => $reliability]);
    }

    public function getImagesIdOfClass (string $class, int $num_of_images) : Collection {
        return Image::where('class', $class)->inRandomOrder()->limit($num_of_images)->get();
    }
}
