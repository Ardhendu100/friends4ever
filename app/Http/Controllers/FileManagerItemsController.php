<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use UniSharp\LaravelFilemanager\Controllers\LfmController;

class FileManagerItemsController extends LfmController
{

    public function index()
    {
        return view('vendor.laravel-filemanager.index');
    }

    public function getItems()
    {
        $currentPage = self::getCurrentPageFromRequest();

        $perPage = $this->helper->getPaginationPerPage();
        $items = array_merge($this->lfm->folders(), $this->lfm->files());

        $allItems = [];
        $startIndex = ($currentPage - 1) * $perPage;
        $itemsToProcess = array_slice($items, $startIndex, $perPage);
        $s3Client = new S3Client([
            'region' => Config::get('filesystems.disks.s3.region'),
            'version' => 'latest',
            'credentials' => [
                'key' => Config::get('filesystems.disks.s3.key'),
                'secret' => Config::get('filesystems.disks.s3.secret'),
            ],
        ]);

        $bucketName = Config::get('filesystems.disks.s3.bucket');
        foreach ($itemsToProcess as $item) {
            $substringToRemove = Config::get('filesystems.disks.s3.url');
            $url = $item->url;

            if (strpos($url, $substringToRemove) !== false) {
                $cleanedUrl = str_replace($substringToRemove, "", $url);
            } else {
                $cleanedUrl = $url;
            }
            $directoryPath = $cleanedUrl;
            $lastModifiedTimes = [];

            $objects = $s3Client->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => $directoryPath,
            ])->get('Contents');
            if ($objects != null) {
                foreach ($objects as $object) {
                    $lastModified = Carbon::parse($object['LastModified']);
                    $lastModified->setTimezone('Asia/Tokyo');
                    $lastModifiedTimes[$object['Key']] = $lastModified->toDateTimeString();
                }
                $times = array_values($lastModifiedTimes);
                $time = $times[0];
                $item->last_modified = $time;
                $allItems[] = $item->fill()->attributes + ['last_modified' => $item->last_modified];
            } else {
                $allItems[] = $item->fill()->attributes;
            }
        }
        return [
            'items' => $allItems,
            'paginator' => [
                'current_page' => $currentPage,
                'total' => count($items),
                'per_page' => $perPage,
            ],
            'display' => $this->helper->getDisplayMode(),
            'working_dir' => $this->lfm->path('working_dir'),
        ];
    }

    private static function getCurrentPageFromRequest()
    {
        $currentPage = (int) request()->get('page', 1);
        $currentPage = $currentPage < 1 ? 1 : $currentPage;

        return $currentPage;
    }

    public function download() {
        $file = $this->lfm->setName(request('file'));

        if (!Storage::disk($this->helper->config('disk'))->exists($file->path('storage'))) {
            abort(404);
        }

        return Storage::disk($this->helper->config('disk'))->download($file->path('storage'));
    }
}
