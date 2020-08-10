<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use App\Models\Picture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResizeImageSave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $imgOriginal;
    private $width;
    private $height;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imgOriginal, $width, $height)
    {
        $this->imgOriginal = $imgOriginal;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image = $this->imgOriginal;
        $img = Image::make(storage_path('app\public\img')."\\". $image->storage . "\\". $image->name)->resize($this->width, $this->height);

        Picture::create([
            'name' => $image->name,
            'storage' => 'resize',
            'path' => 'app\public\img\resize'."\\". $image->name,
            'type' => substr(strrchr($image->name, '.'), 1),
        ]);

        $img->save(storage_path('app\public\img\resize')."\\". $image->name);
    }
}
