<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'image_name',
        'file_path',
        // Add any other fillable fields as needed
    ];
}

?>