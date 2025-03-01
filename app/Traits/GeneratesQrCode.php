<?php

namespace App\Traits;

use App\Helper\Files;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Support\Facades\Storage;

trait GeneratesQrCode
{
    public function createQrCode(string $qrUrl, ?string $label = null)
    {
        $fileName = $this->getQrCodeFileName();
        $filePath = public_path(Files::UPLOAD_FOLDER . '/qrcodes/' . $fileName);

        $builder = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($qrUrl)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->validateResult(false);

        if ($label) {
            $builder->labelText($label)
                ->labelFont(new \Endroid\QrCode\Label\Font\NotoSans(20))
                ->labelAlignment(\Endroid\QrCode\Label\LabelAlignment::Center);
        }

        $result = $builder->build();

        Files::createDirectoryIfNotExist('qrcodes');
        $result->saveToFile($filePath);

        Files::fileStore(
            new File($filePath),
            'qrcodes',
            $fileName,
            uploaded: false,
            restaurantId: $this->getRestaurantId()
        );

        // Move file to cloud storage
        if (config('filesystems.default') !== 'local') {
            $contents = FileFacade::get($filePath);
            Storage::disk(config('filesystems.default'))->put('qrcodes/' . $fileName, $contents);
            // Delete local file
            unlink($filePath);
        }
    }

    abstract protected function getQrCodeFileName(): string;
    abstract protected function getRestaurantId(): int;
}
