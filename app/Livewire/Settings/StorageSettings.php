<?php

namespace App\Livewire\Settings;

use App\Models\FileStorage;
use App\Models\StorageSetting;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;

class StorageSettings extends Component
{
    use LivewireAlert;

    public $settings;
    public $storage;
    public $awsKeys;
    public $digitaloceanKeys;
    public $awsCredentials;
    public $digitalOceanCredentials;
    public $wasabiCredentials;
    public $minioCredentials;
    public $localCredentials;
    public $digitaloceanKey;
    public $digitaloceanSecretKey;
    public $digitaloceanBucket;
    public $digitaloceanRegion;
    public $wasabiKey;
    public $wasabiAccessKey;
    public $wasabiSecretKey;
    public $wasabiBucket;
    public $wasabiRegion;
    public $wasabiKeys;
    public $awsRegion;
    public $awsBucket;
    public $awsSecretKey;
    public $awsAccessKey;
    public $minioAccessKey;
    public $minioSecretKey;
    public $minioBucket;
    public $minioRegion;
    public $minioEndpoint;
    public $minioKeys;
    public $showTestStorageModal = false;
    public $showMoveFilesToCloudModal = false;
    public $localFilesCount;

    public function mount()
    {
        $this->awsCredentials = StorageSetting::where('filesystem', 'aws_s3')->first();
        $this->digitalOceanCredentials = StorageSetting::where('filesystem', 'digitalocean')->first();
        $this->wasabiCredentials = StorageSetting::where('filesystem', 'wasabi')->first();
        $this->minioCredentials = StorageSetting::where('filesystem', 'minio')->first();
        $this->localCredentials = StorageSetting::where('filesystem', 'local')->first();

        if (!is_null($this->awsCredentials)) {
            try {
                $this->awsKeys = json_decode($this->awsCredentials->auth_keys);
                $this->awsRegion = $this->awsKeys->region;
                $this->awsBucket = $this->awsKeys->bucket;
                $this->awsSecretKey = $this->awsKeys->secret_key;
                $this->awsAccessKey = $this->awsKeys->access_key;
            } catch (\Exception $e) {

                $this->awsCredentials->auth_keys = null;
                $this->awsCredentials->save();
            }
        }

        if (!is_null($this->digitalOceanCredentials)) {
            try {
                $this->digitaloceanKeys = json_decode($this->digitalOceanCredentials->auth_keys);
                $this->digitaloceanKey = $this->digitaloceanKeys->access_key;
                $this->digitaloceanSecretKey = $this->digitaloceanKeys->secret_key;
                $this->digitaloceanBucket = $this->digitaloceanKeys->bucket;
                $this->digitaloceanRegion = $this->digitaloceanKeys->region;
            } catch (\Exception $e) {
                $this->digitalOceanCredentials->auth_keys = null;
                $this->digitalOceanCredentials->save();
            }
        }

        if (!is_null($this->wasabiCredentials)) {
            try {
                $this->wasabiKeys = json_decode($this->wasabiCredentials->auth_keys);
                $this->wasabiAccessKey = $this->wasabiKeys->access_key;
                $this->wasabiSecretKey = $this->wasabiKeys->secret_key;
                $this->wasabiBucket = $this->wasabiKeys->bucket;
                $this->wasabiRegion = $this->wasabiKeys->region;
            } catch (\Exception $e) {
                $this->wasabiCredentials->auth_keys = null;
                $this->wasabiCredentials->save();
            }
        }

        if (!is_null($this->minioCredentials)) {
            try {
                $this->minioKeys = json_decode($this->minioCredentials->auth_keys);
                $this->minioAccessKey = $this->minioKeys->access_key;
                $this->minioSecretKey = $this->minioKeys->secret_key;
                $this->minioBucket = $this->minioKeys->bucket;
                $this->minioRegion = $this->minioKeys->region;
                $this->minioEndpoint = $this->minioKeys->endpoint;
            } catch (\Exception $e) {
                $this->minioCredentials->auth_keys = null;
                $this->minioCredentials->save();
            }
        }

        $this->settings = StorageSetting::where('status', 'enabled')->first();
        $this->localFilesCount = FileStorage::where('storage_location', 'local')->count();

        $this->storage = $this->settings->filesystem;
    }

    public function showTestStorage()
    {
        $this->showTestStorageModal = true;
    }

    #[On('hideTestStorageModal')]
    public function hideTestStorageModal()
    {
        $this->showTestStorageModal = false;
    }

    public function showMoveFilesToCloud()
    {
        $this->showMoveFilesToCloudModal = true;
    }

    #[On('hideMoveFilesToCloudModal')]
    public function hideMoveFilesToCloudModal()
    {
        $this->showMoveFilesToCloudModal = false;
    }

    public function submitForm()
    {

        $this->validate([
            'storage' => 'required',
            'digitaloceanKey' => 'required_if:storage,digitalocean',
            'digitaloceanSecretKey' => 'required_if:storage,digitalocean',
            'digitaloceanBucket' => 'required_if:storage,digitalocean',
            'digitaloceanRegion' => 'required_if:storage,digitalocean',
            'wasabiAccessKey' => 'required_if:storage,wasabi',
            'wasabiSecretKey' => 'required_if:storage,wasabi',
            'wasabiBucket' => 'required_if:storage,wasabi',
            'wasabiRegion' => 'required_if:storage,wasabi   ',
            'awsAccessKey' => 'required_if:storage,aws_s3',
            'awsSecretKey' => 'required_if:storage,aws_s3',
            'awsBucket' => 'required_if:storage,aws_s3',
            'awsRegion' => 'required_if:storage,aws_s3',
            'minioAccessKey' => 'required_if:storage,minio',
            'minioSecretKey' => 'required_if:storage,minio',
            'minioBucket' => 'required_if:storage,minio',
            'minioRegion' => 'required_if:storage,minio',
            'minioEndpoint' => 'required_if:storage,minio',
        ]);

        StorageSetting::query()->update(['status' => 'disabled']);

        $storage = StorageSetting::firstorNew(['filesystem' => $this->storage]);

        switch ($this->storage) {
            case 'digitalocean':

                $arrayResponse = [
                    'driver' => 's3',
                    'access_key' => $this->digitaloceanKey,
                    'secret_key' => $this->digitaloceanSecretKey,
                    'region' => $this->digitaloceanRegion,
                    'bucket' => $this->digitaloceanBucket,
                ];
                $storage->auth_keys = json_encode($arrayResponse);
                break;
            case 'wasabi':

                $arrayResponse = [
                    'driver' => 's3',
                    'access_key' => $this->wasabiAccessKey,
                    'secret_key' => $this->wasabiSecretKey,
                    'region' => $this->wasabiRegion,
                    'bucket' => $this->wasabiBucket,
                ];
                $storage->auth_keys = json_encode($arrayResponse);
                break;

            case 'aws_s3':
                $arrayResponse = [
                    'driver' => 's3',
                    'access_key' => $this->awsAccessKey,
                    'secret_key' => $this->awsSecretKey,
                    'region' => $this->awsRegion,
                    'bucket' => $this->awsBucket,
                ];
                $storage->auth_keys = json_encode($arrayResponse);
                break;

            case 'minio':
                $arrayResponse = [
                    'driver' => 's3',
                    'access_key' => $this->minioAccessKey,
                    'secret_key' => $this->minioSecretKey,
                    'region' => $this->minioRegion,
                    'bucket' => $this->minioBucket,
                    'endpoint' => $this->minioEndpoint,
                ];
                $storage->auth_keys = json_encode($arrayResponse);
                break;
        }

        $storage->filesystem = $this->storage;
        $storage->status = 'enabled';
        $storage->save();

        cache()->forget('storage-setting');
        session()->forget('storage-setting');
        session(['storage_setting' => $storage]);

        $this->alert('success', __('messages.settingsUpdated'), [
            'toast' => true,
            'position' => 'top-end',
            'showCancelButton' => false,
            'cancelButtonText' => __('app.close')
        ]);
    }

    public function render()
    {
        return view('livewire.settings.storage-settings');
    }
}
