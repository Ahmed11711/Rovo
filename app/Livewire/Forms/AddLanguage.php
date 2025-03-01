<?php

namespace App\Livewire\Forms;

use App\Models\LanguageSetting;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddLanguage extends Component
{

    use LivewireAlert;

    public $languageCode;
    public $languageName;
    public $flagCode;
    public $isRtl;
    public $langPath;
    public function mount()
    {
        $this->languageCode = '';
        $this->languageName = '';
        $this->flagCode = '';
        $this->isRtl = false;
        $this->langPath = base_path() . '/lang';
    }

    public function submitForm()
    {
        $this->validate([
            'languageCode' => 'required|unique:language_settings,language_code',
            'languageName' => 'required',
            'flagCode' => 'required',
        ]);


        // check and create lang folder
        $langExists = File::exists($this->langPath . '/' . $this->languageCode);

        if (!$langExists) {
            File::makeDirectory($this->langPath . '/' . $this->languageCode);
        }

        LanguageSetting::create([
            'language_code' => $this->languageCode,
            'language_name' => $this->languageName,
            'flag_code' => $this->flagCode,
            'is_rtl' => $this->isRtl,
        ]);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);

        cache()->forget('languages');

        $this->dispatch('hideAddLanguage');
    }

    public function render()
    {
        return view('livewire.forms.add-language');
    }
}
