<?php

use Illuminate\Database\Seeder;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatar = new Avatar();
        $users = \App\User::all();
        foreach ($users as $user) {
            $avatar->create($user->name)->save(storage_path('app/public/avatars/user-' . $user->id . '.png'), $quality = 90);
        }
        $numberOfProductImages = 100;
        $this->fetchAllProductImages($numberOfProductImages);
    }

    protected function fetchProductImage($id) {
        $path = 'public/products';
        $filename = 'product-'.$id.'.jpg';

        if (! Storage::disk('local')->exists($path.'/'.$filename)) {
            $url = "https://loremflickr.com/640/480/vegetables";
            $info = pathinfo($url);
            $contents = file_get_contents($url);
            $file = '/tmp/' . $info['basename'];
            file_put_contents($file, $contents);
            $uploaded_file = new UploadedFile($file, $info['basename']);
            Storage::putFileAs($path, $uploaded_file, $filename);
        }
    }

    protected function fetchAllProductImages($count) {
        $iteration = 0;
        do {
            $iteration++;
            $this->fetchProductImage($iteration);
        } while ($iteration < $count);
    }
}