<?php


namespace Lessipe\Larabase\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Presenter
{
    /**
     * @var Model|Collection|null
     */
    protected $model = null;

    /**
     * @param Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function present()
    {
        if ($this->model instanceof Model) {
            return $this->parse($this->model);
        } else if ($this->model instanceof Collection || is_array($this->model)) {
            $result = collect();

            foreach ($this->model as $model) {
                $result->push($this->parse($model));
            }

            return $result->toArray();
        }

        return [];
    }

    /**
     * @param Model $model
     * @return array
     */
    abstract protected function parse(Model $model): array;
}
