<?php


namespace Lessipe\Larabase\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['file_name', 'original_name', 'fileable_id', 'fileable_type', 'type', 'rank',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo();
    }
}
