<?php declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param array $modelDetails
     * @return mixed
     */
    public function create(array $modelDetails);

    /**
     * @param $id
     * @param array $newDetails
     * @return mixed
     */
    public function update($id, array $newDetails);

    /**
     * @param array $ids
     * @return mixed
     */
    public function findMany(array $ids);

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function like($column, $value);

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function where($column, $value);

    /**
     * @param $column
     * @param $start
     * @param $end
     * @return mixed
     */
    public function between($column, $start, $end);

    /**
     * @param $relation
     * @return mixed
     */
    public function with($relation);
}
