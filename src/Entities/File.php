<?php


namespace Visualplus\Larabase\Entities;

use Illuminate\Database\Eloquent\Model;
use Visualplus\Larabase\Contracts\Presentable;
use Visualplus\Larabase\Traits\PresentableTrait;

class File extends Model implements Presentable
{
    use PresentableTrait;

    protected $fillable = ['file_name', 'original_name', 'fileable_id', 'fileable_type', 'type', 'rank',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}