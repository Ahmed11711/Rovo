<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Helper\Reply;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Zip;

class GlobalSettingController extends Controller
{

    public function index()
    {

        try {
            $results = DB::select('select version()');
            $mysql_version = $results[0]->{'version()'};
            $databaseType = 'MySQL Version';

            if (str_contains($mysql_version, 'Maria')) {
                $databaseType = 'Maria Version';
            }
        } catch (\Exception $e) {
            $mysql_version = null;
            $databaseType = 'MySQL Version';
        }

        $reviewed = file_exists(storage_path('reviewed'));
        
        return view('app_update.index', compact('mysql_version', 'databaseType', 'reviewed'));
    }

    public function store(Request $request)
    {
     

        config(['filesystems.default' => 'storage']);
        $path = storage_path('app') . '/Modules/' . $request->file->getClientOriginalName();

        if (file_exists($path)) {
            File::delete($path);
        }

        $request->file->storeAs('/', $request->file->getClientOriginalName());
    }

    public function deleteFile(Request $request)
    {
        $filePath = $request->filePath;
        File::delete($filePath);

        return Reply::success(__('messages.deleteSuccess'));
    }

}
