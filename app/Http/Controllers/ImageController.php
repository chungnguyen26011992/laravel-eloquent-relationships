<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function getParentModelOfImage(Request $request) {
        $image = Image::find(1);
        $imageable = $image->imageable;
        return $imageable;
    }
}
