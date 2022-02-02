<?php

namespace App\Traits;

use Image;
use Exception;
use Carbon\Carbon;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    /**
     * Upload file to default storage disk
     *
     * @access public
     *
     * @param UploadedFile $file
     * @param string $type
     * @param string|null $folder
     *
     * @return File
     */
    public function upload(UploadedFile $file, string $type = null, string $folder = null, $fileName = null, $reference = null, $duration = null): File
    {
        $data['type'] = $type;
        // Get extension
        $data['ext'] = $file->extension();
        // Get mime type
        $data['mime'] = $file->getMimeType();

        $data['name'] = $fileName;

        $data['url'] = 'upload/'. $folder. '/'. $fileName;

        // Save new file object to DB
        return File::create($data);
    }

    /**
     * Delete file from storage & DB
     *
     * @access public
     *
     * @param File $file
     *
     * @return bool
     * @throws CantDeleteModelException
     */
    public function deleteFile(File $file): bool
    {
        if (Storage::exists($file->url)) {
            Storage::delete($file->url);
        }

        return $file->delete();
    }

    public function deleteFiles(Collection $files)
    {
        return true;
    }

    /**
     * Check and create directory if not exists.
     *
     * @access protected
     *
     * @param  string $folder
     *
     * @return bool
     */
    public function createDirectoryIfNotExists($folder): bool
    {
        // Check if dri exists
        if (Storage::exists($folder)) {
            return true;
        }

        // Create new dir
        try {
            Storage::makeDirectory($folder);
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function generateImage($file)
    {
        $maxWidth = config('Arzan.upload.max_width');

        // Create Intervention image
        $image = Image::make($file);

        // resize image
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        return $image;
    }

    public function filterFileName($filename, $beautify = false)
    {
        $filteredName = preg_replace('/[^\x{0600}-\x{06FF}A-Za-z0-9.]/u', '-', $filename);

        // optional beautification
        if ($beautify) {
            $filteredName = $this->beautifyFilename($filteredName);
        }

        return $filteredName;
    }

    public function beautifyFilename($filename)
    {
        // reduce consecutive characters
        // "file   name.zip" becomes "file-name.zip"
        // "file___name.zip" becomes "file-name.zip"
        // "file---name.zip" becomes "file-name.zip"

        $filename = preg_replace(array(
            '/ +/',
            '/_+/',
            '/-+/'
        ), '-', $filename);

        // "file--.--.-.--name.zip" becomes "file.name.zip"
        // "file...name..zip" becomes "file.name.zip"

        $filename = preg_replace(array(
            '/-*\.-*/',
            '/\.{2,}/'
        ), '.', $filename);

        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        // $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        $filename = mb_strtolower($filename, 'UTF-8');

        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');

        return $filename;
    }

    public function upload_file($name, $dir, $file, $type, $model, $method = 'create')
    {
        $path = '/files/'.$type.'/'.$dir;
        $ext  = strtolower($file->getClientOriginalExtension());
        $fileName = $path.'/'.$name.'.'.$ext;
        $name = $name.'.'.$ext;
        $file->move(public_path($path), $fileName);
        if ($method == 'update') {
            $model->avatar()->update(['name'=>$name,'url'=>$fileName]);
        } else {
            $model->avatar()->create(['name'=>$name,'url'=>$fileName]);
        }
    }
}
