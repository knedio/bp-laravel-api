<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = [
        'name',
        'description',
        'path',
        'size',
        'type',
    ];

    public static function store($data)
    {
        $description = '';
        extract($data);
        
        $file_mime_type = $attachment->getClientMimeType();
        $file_name = $attachment->getClientOriginalName();
        $file_extension = $attachment->getClientOriginalExtension();
        $file_size = $attachment->getClientSize();

        $is_file_exist = File::isFileExist($path.$file_name);
        $count = 1;
        
        /**
         * Check if the file is exist
         * if exist then add incremental value in file name
         * purpose for this is to avoid same file name
         */
        while ($is_file_exist) {
	    	$exploded_file_name = explode('.', $file_name);
	    	$file_name_only = implode('', array_slice($exploded_file_name, 0, -1));
	    	$added_string = '('.$count.')';
    		$file_name = $file_name_only.$added_string.'.'.$file_extension;
        	$count += 1;
        	$is_file_exist = File::isFileExist($path.$file_name);
        }

        $file =  File::create([
            'name'          => $file_name,
            'description'   => $description,
            'path'          => $path.$file_name,
            'size'          => $file_size,
            'type'          => $file_mime_type,
        ]);

        Storage::disk('public')->put($path.$file_name, file_get_contents($attachment));

        return $file;
    }

    public static function isFileExist($path)
    {
    	$is_exist = File::where('path',$path)->count();

    	return $is_exist > 0 ? true : false;
    }
}
