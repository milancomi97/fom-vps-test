<?php declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(
        protected readonly Model $model
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $newDetails)
    {
        return $this->model->whereId($id)->update($newDetails);
    }
    /**
     * Get records based on a list of IDs.
     *
     * @param  array  $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany(array $ids)
    {
        return $this->model->findMany($ids);
    }

    /**
     * Get records where the given column is like the specified value.
     *
     * @param  string  $column
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function like($column, $value)
    {
        return $this->model->where($column, 'like', '%' . $value . '%')->get();
    }

    /**
     * Get records where the given column is between the specified values.
     *
     * @param  string  $column
     * @param  mixed  $start
     * @param  mixed  $end
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function between($column, $start, $end)
    {
        return $this->model->whereBetween($column, [$start, $end]);
    }

    /**
     * Get records with a specified relationship eager-loaded.
     *
     * @param  string  $relation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function with($relation)
    {
        return $this->model->with($relation);
    }

    public function where($column, $value)
    {
        return $this->model->where($column,$value);
    }


    public function whereCondition($column,$condition, $value)
    {
        return $this->model->where($column,$condition,$value);
    }
    public function whereIn($column, $value)
    {
        return $this->model->whereIn($column,$value);
    }
}
