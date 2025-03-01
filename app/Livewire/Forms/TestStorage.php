<?php

namespace App\Livewire\Forms;

use App\Helper\Files;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helpers\Reply;

class TestStorage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $file;
    public $fileUrl;

    public function submitForm()
    {
        try {
            $filename = Files::uploadLocalOrS3($this->file, '/');
        } catch (\Exception $e) {
            $this->addError('file_error', $e->getMessage());
            return true;
        }

        $fileUrl = asset_url_local_s3($filename);

        $this->fileUrl = $fileUrl;
    }

    public function render()
    {
        return view('livewire.forms.test-storage');
    }
}
