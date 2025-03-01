<?php

namespace App\Livewire\Forms;

use App\Models\FileStorage;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Helper\Files;

class MoveFilesToCloud extends Component
{
    public $localFiles = [];
    public $progress = 0;

    public function mount()
    {
        $this->localFiles = FileStorage::where('storage_location', 'local')->get();
    }

    public function moveToCloud()
    {
        $total = count($this->localFiles);
        $current = 0;

        foreach ($this->localFiles as $file) {
            $filePath = public_path(Files::UPLOAD_FOLDER . '/' . $file->path . '/' . $file->filename);

            if (!File::exists($filePath)) {
                $file->delete();
                continue;
            }

            $contents = File::get($filePath);
            $uploaded = Storage::disk(config('filesystems.default'))->put($file->path . '/' . $file->filename, $contents);

            if ($uploaded) {
                $file->storage_location = config('filesystems.default') === 's3' ? 'aws_s3' : config('filesystems.default');
                $file->save();
                $this->deleteFileFromLocal($filePath);
            }

            $current++;
            $this->progress = round(($current / $total) * 100);
        }

        $this->reset(['localFiles', 'progress']);

        $this->dispatch('hideMoveFilesToCloudModal');
    }

    private function deleteFileFromLocal($filePath)
    {
        if (File::exists($filePath)) {
            try {
                unlink($filePath);
            } catch (\Throwable $th) {
                return true;
            }
        }
    }

    public function render()
    {
        return view('livewire.forms.move-files-to-cloud');
    }
}
