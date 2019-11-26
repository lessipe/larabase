<?php


namespace Lessipe\Larabase\Contracts;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Lessipe\Larabase\Entities\File;
use Illuminate\Database\Eloquent\Model;


abstract class Service
{
    /**
     * @param File $file
     * @param Model $parent
     * @param $path
     * @param null $type
     * @param int $rank
     * @return File
     */
    protected function fileCopy(File $file, Model $parent, $path, $type = null, $rank = 0)
    {
        $fileName = $this->uniqueFileName($path, pathinfo($file->file_name, PATHINFO_EXTENSION));

        Storage::copy($file->file_name, $path . '/' . $fileName);

        return File::create([
            'file_name' => $path . '/' . $fileName,
            'original_name' => $file->original_name,
            'fileable_id' => $parent->getKey(),
            'fileable_type' => get_class($parent),
            'type' => $type,
            'rank' => $rank,
        ]);
    }

    /**
     * @param File $file
     */
    protected function fileDestroy(File $file)
    {
        Storage::delete($file->file_name);
        File::destroy($file->getKey());
    }

    /**
     * @param Model $parent
     * @param UploadedFile $file
     * @param $path
     * @param null $type
     * @param int $rank
     * @return File
     */
    protected function fileUpload(Model $parent, UploadedFile $file, $path, $type = null, $rank = 0)
    {
        $path = $file->storeAs($path, $this->getUniqueFileName($file, $path));

        return File::create([
            'file_name' => $path,
            'original_name' => $file->getClientOriginalName(),
            'fileable_id' => $parent->getKey(),
            'fileable_type' => get_class($parent),
            'type' => $type,
            'rank' => $rank,
        ]);
    }

    /**
     * @param Model $parent
     * @param $tmpPath
     * @param $path
     * @param null $type
     * @param int $rank
     * @return File
     */
    protected function fileMove(Model $parent, $tmpPath, $path, $type = null, $rank = 0)
    {
        $extension = pathinfo($tmpPath, PATHINFO_EXTENSION);

        $fileName = $this->uniqueFileName($path, $extension);

        Storage::move($tmpPath, $path . '/' . $fileName);

        return File::create([
            'file_name' => $path . '/' . $fileName,
            'original_name' => '',
            'fileable_id' => $parent->getKey(),
            'fileable_type' => get_class($parent),
            'type' => $type,
            'rank' => $rank
        ]);
    }

    /**
     * @param UploadedFile $file
     * @param $path
     * @return string
     */
    private function getUniqueFileName(UploadedFile $file, $path)
    {
        $extension = $file->getClientOriginalExtension();

        return $this->uniqueFileName($path, $extension);
    }

    /**
     * @param $path
     * @param $extension
     * @return string
     */
    private function uniqueFileName($path, $extension)
    {
        do {
            $fileName = time() . rand(1000, 9999) . '.' . $extension;
        } while (Storage::exists($path . '/' . $fileName));

        return $fileName;
    }
}
