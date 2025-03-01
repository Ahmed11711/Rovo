<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class DisableLanding extends Component
{

    use LivewireAlert;

    public $settings;
    public $disableLandingSite;
    public $landingSiteType;
    public $landingSiteUrl;
    public $facebook;
    public $instagram;
    public $twitter;
    public $yelp;
    public $metaKeyword;
    public $metaDescription;

    public function mount()
    {
        $this->disableLandingSite = (bool)$this->settings->disable_landing_site;
        $this->landingSiteType = $this->settings->landing_site_type;
        $this->landingSiteUrl = $this->settings->landing_site_url;
        $this->facebook = $this->settings->facebook_link;
        $this->instagram = $this->settings->instagram_link;
        $this->twitter = $this->settings->twitter_link;
        $this->yelp = $this->settings->yelp_link;
        $this->metaKeyword = $this->settings->meta_keyword;
        $this->metaDescription = $this->settings->meta_description;
    }

    public function submitForm()
    {

        $this->validate([
            'landingSiteUrl' => 'required_if:landingSiteType,custom|nullable|url',
        ]);

        $this->settings->disable_landing_site = $this->disableLandingSite;
        $this->settings->landing_site_type = $this->landingSiteType;
        $this->settings->landing_site_url = $this->landingSiteUrl;
        $this->settings->facebook_link = $this->facebook;
        $this->settings->instagram_link = $this->instagram;
        $this->settings->twitter_link = $this->twitter;
        $this->settings->yelp_link = $this->yelp;
        $this->settings->meta_keyword = $this->metaKeyword;
        $this->settings->meta_description = $this->metaDescription;
        $this->settings->save();

        cache()->forget('global_setting');

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.forms.disable-landing');
    }

}
