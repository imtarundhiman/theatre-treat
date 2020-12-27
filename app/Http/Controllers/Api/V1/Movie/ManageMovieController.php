<?php

namespace App\Http\Controllers\Api\V1\Movie;

use App\Http\Requests\Api\V1\Movie\AddMovieRequest;
use App\Http\Controllers\Api\ApiController;
use App\Models\Movie;
use App\Models\Resource;
use Storage;
use Image;
use Symfony\Component\HttpFoundation\Request;

class ManageMovieController extends ApiController
{
    public function index(Request $request){
        $this->authorize('all', Movie::class);

        $perPageRecords = $request->has('per_page') ? $request->per_page : $this->pageLimit;

        $movies = Movie::orderBy('created_at','desc');

        if ($request->exists('nopaging')) {
            $movies = $movies->get();
        } else {
            $movies = $movies->paginate($perPageRecords);
        }

        return $this->respondWithData($movies->toArray());
    }   

    public function store(AddMovieRequest $request){

        $this->authorize('all', Movie::class);
        
        $params = $request->only('movie_name','genre','description','releasing_date');

        $movie = new Movie;

        $movie->movie_name = $params['movie_name'];
        $movie->genre = $params['genre'];
        $movie->description = $params['description'];
        $movie->slug = str_slug($params['movie_name']);
        $movie->releasing_date = $params['releasing_date'];

        if(!$movie->save()){
            return $this->respondDataNotSaved();
        }

        $this->uploadMovieResource($request->file, $movie);

        return $this->setStatusCode(200)->respondWithData($movie->load('image')->toArray(),'successfully saved !');
    }

    public function uploadMovieResource($file, $movie){ 
        $storageDiskDriver = 'public';

        $storageDisk = Storage::disk($storageDiskDriver);

        $resourceType = $file->getClientOriginalExtension();
            
        $fileName = md5(microtime().rand()).'.'.$file->getClientOriginalExtension();

        $path = "uploads/{$fileName}";

        $resizedImage = Image::make($file->getRealPath())->fit(200,200)->stream();

        $storageDisk->put($path, $resizedImage->__toString());
    
        Resource::insert([
            'resourceable_id' => $movie->id,
            'resourceable_type' => Movie::class,
            'resource_name'=> $fileName,
            'resource_path'=> $path,
            'resource_type' => $resourceType,
            'storage_driver' => $storageDiskDriver
        ]);
    }
}
