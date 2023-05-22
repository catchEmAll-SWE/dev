<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Http\Resources\V1\ImageResource;

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
    
    private function getAllClasses() : array {
        $array = Image::select('class')->distinct()->get()->toArray();
        foreach($array as $key => $value){
            $array[$key] = $value['class'];
        }
        return $array;
    }

    public function getCaptchaClasses(int $num_of_classes) : array{
        $array = $this->getAllClasses();
        $captcha_classes = [];
        for($i = 0; $i<$num_of_classes; $i++){
            $rnd = rand(0,count($array)-1);
            $captcha_classes[$i] = $array[$rnd];
            array_splice($array, $rnd, 1);
        }

        return Image::select('class')->distinct()->inRandomOrder()->limit($num_of_classes)->get()->toArray();

        return $captcha_classes;
    }

    public function updateReliability(string $id, int $reliability) : void {
        Image::where('id', $id)->update(['reliability' => $reliability]);
    }

    public function getImagesOfClass(string $class, int $num_of_images){
        return ImageResource::collection(Image::where('class', $class)->inRandomOrder()->limit($num_of_images)->get());
    }
}
