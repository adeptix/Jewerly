<?php

namespace Tests\Unit;


use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use Optix\Media\MediaUploader;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileServiceTest extends TestCase
{



    public function test_attach_main()
    {
        $fileService = new FileService();
        $product = Product::find(1);

        $main_image = MediaUploader::fromFile(UploadedFile::fake()->image('main-1.jpg'))->upload()->id;


        $fileService->attachFiles($main_image, $product, 'main');

        $this->assertNotEmpty($product->getMainMediaUrl());

    }

    public function test_attach_gallery(){
        $fileService = new FileService();
        $product = Product::find(1);

        $gallery = [
            MediaUploader::fromFile(UploadedFile::fake()->image('file-name-2.png'))->upload()->id,
            MediaUploader::fromFile(UploadedFile::fake()->image('file-name-3.jpg'))->upload()->id
        ];

        $fileService->attachFiles($gallery, $product, 'gallery');

        $this->assertNotEmpty($product->getGalleryMediaUrl());

    }


}
