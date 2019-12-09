<?php


namespace App\Services;


use App\Models\Product;

class FileService
{
    public function attachFiles($files, Product $product, $group = null)
    {

        if (!$group){
            $product->detachMedia();
            $product->attachMedia($files);
            return;
        }

        $product->clearMediaGroup($group);
        $product->attachMedia($files, $group);

    }




    public function detachFiles(Product $product)
    {
        $product->detachMedia();
    }




}
