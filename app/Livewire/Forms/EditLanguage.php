<?php

namespace App\Livewire\Forms;

use App\Models\LanguageSetting;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Barryvdh\TranslationManager\Models\Translation;

class EditLanguage extends Component
{
    use LivewireAlert;

    public $language;
    public $languageCode;
    public $languageName;
    public $flagCode;
    public $isRtl;
    public $langPath;
    
    public function mount()
    {
        $this->languageCode = $this->language->language_code;
        $this->languageName = $this->language->language_name;
        $this->flagCode = $this->language->flag_code;
        $this->isRtl = $this->language->is_rtl;

        $this->langPath = base_path() . '/lang';
    }

    public function submitForm()
    {
        $this->validate([
            'languageCode' => 'required|unique:language_settings,language_code,' . $this->language->id,
            'languageName' => 'required',
            'flagCode' => 'required',
        ]);

        $setting = LanguageSetting::findOrFail($this->language->id);

        $oldLangExists = File::exists($this->langPath.'/'.$setting->language_code);

        if($oldLangExists){
            // check and create lang folder
            $langExists = File::exists($this->langPath . '/' . $this->languageCode);

            if (!$langExists) {
                // update lang folder name
                File::move($this->langPath . '/' . $setting->language_code, $this->langPath . '/' . $this->languageCode);

                Translation::where('locale', $setting->language_code)->get()->map(function ($translation) {
                    $translation->delete();
                });
            }
        }

        LanguageSetting::where('id', $this->language->id)->update([
            'language_code' => $this->languageCode,
            'language_name' => $this->languageName,
            'flag_code' => $this->flagCode,
            'is_rtl' => $this->isRtl
        ]);

        cache()->forget('languages');

        $this->dispatch('hideEditLanguage');

        $this->alert('success', __('messages.languageUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.edit-language');
    }
}
