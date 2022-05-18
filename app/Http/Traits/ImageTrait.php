<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

/**
 * A trait to improve my code and prevent code duplication when saving an image
 */
trait ImageTrait
{
    protected function save_file($file, $storage_path)
    {
        $relative_path = $file->store($storage_path);
        return $relative_path;
    }

    public static function update_file($storage_path, $file , $old_file)
    {
        if(Storage::exists($old_file)){
            Storage::delete($old_file);
        }
        $url = $file->store($storage_path);
        return $url;
    }

    public static function delete_file($file)
    {
        if(Storage::exists($file)){
            Storage::delete($file);
        }
        return true;
    }
}
