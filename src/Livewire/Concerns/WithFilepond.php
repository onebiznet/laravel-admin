<?php 

namespace OneBiznet\Admin\Livewire\Concerns;

use OneBiznet\Admin\Models\Media;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

trait WithFilepond 
{
    use WithFileUploads;
    
    public $forDeletion = [];

    public function mountWithFilepond() {
    }

    public function removeFile($source, $model)
    {
        $files = $this->getPropertyValue($model);

        foreach($files as $index => $file) {
            if($file instanceof TemporaryUploadedFile) continue;
            if ($file['id'] == $source) {
                $this->forDeletion[] = $file;
                unset($this->{$model}[$index]);

                return $file;
            }
        }

        return false;
    }

    public function processFiles($delete = true) {
        foreach($this->forDeletion as $index => $file) {
            if ($delete && $media = Media::find($file['id'])) {
                $media->delete();
            }
            unset($this->forDeletion[$index]);        
        }
    }

    public function reorder($model, $origin, $target)
    {
        [$this->{$model}[$origin], $this->{$model}[$target]] = [$this->{$model}[$target], $this->{$model}[$origin]];
        
        return $this->{$model};
    }
}