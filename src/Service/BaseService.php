<?php

namespace Visualplus\Larabase\Service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\UnauthorizedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\LaravelValidator;
use Gate;
use Storage;
use Visualplus\Larabase\Entities\File;

abstract class BaseService
{
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
     * @param array $data
     * @param string $rule
     * @throws ValidatorException
     */
    protected function validate(array $data, $rule)
    {
        $validator = $this->getValidator();

        if (! $validator->with($data)->passes($rule)) {
            throw new ValidatorException($validator->errorsBag());
        }
    }

    /**
     * @param $target
     * @param string $rule
     * @throws UnauthorizedException
     * @return void
     */
    protected function authorize($target, $rule = 'create')
    {
        if (Gate::denies($rule, $target)) {
            throw new UnauthorizedException();
        }
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

    /**
     * @return LaravelValidator
     */
    abstract protected function getValidator();
}