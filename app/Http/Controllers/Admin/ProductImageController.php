<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy($id) {
        $image = ProductImage::where('id', $id)->first();
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->back()
        ->with('message', 'Image Removed Successfully.');
    }
}
