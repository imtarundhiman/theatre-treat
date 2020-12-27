<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Resource extends Model
{
    protected $appends = ['public_url'];

    public function getPublicUrlAttribute(){

        try{
            return Storage::disk($this->storage_driver)->url($this->resource_path);
        }
        catch(\Exception $e){}
        catch(\InvalidArgumentException $e){}

        return;
    }
    
    public function resourceable()
    {
        return $this->morphTo();
    }
}
