<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EloquentBaseRepository
 *
 * @author tuannq@vnext.com.vn
 *
 * @package App\Repositories\Eloquent
 */
abstract class EloquentBaseRepository implements BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function find($id, $is = false)
    {
        if (!$is) {
            $data = $this->model->findOrFail($id);
        } else {
            $data = $this->model->whereId($id)->first();
        }

        return $data;
    }

    public function findByColumn($id, string $column)
    {
        $data = $this->model->where($column, $id)->get();
        return $data;
    }


    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

    /**
     * @inheritdoc
     */
    public function paginate($perPage = 25)
    {
        return $this->model->orderBy('id', 'DESC')->paginate($perPage);
    }

    /**
     * @inheritdoc
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function updateData($column, $id, $data)
    {
        $result = $this->model->where($column, $id)->update($data);

        return $result;
    }

    public function findWhere($id, $column)
    {
        $result = $this->model->where($column, $id);
        return $result;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function findBySlug($slug, $status = false)
    {
        $query = $this->model->whereSlug($slug);
        if ($status == true) {
            $query = $query->whereStatus(true);
        }

        return $query->firstOrFail();
    }

    /**
     * @inheritdoc
     */
    public function findByEmail($email)
    {
        return $this->model->whereEmail($email)->first();
    }

    /**
     * @inheritdoc
     */
    public function findByAttributes(array $attributes)
    {
        $query = $this->buildQueryByAttributes($attributes);

        return $query->first();
    }

    /**
     * Build Query to catch resources by an array of attributes and params
     * @param array $attributes
     * @param null|string $orderBy
     * @param string $sortOrder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function buildQueryByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->model->query();

        foreach ($attributes as $field => $value) {
            $query = $query->where($field, $value);
        }

        if (null !== $orderBy) {
            $query->orderBy($orderBy, $sortOrder);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc')
    {
        $query = $this->buildQueryByAttributes($attributes, $orderBy, $sortOrder);

        return $query->get();
    }

    /**
     * @inheritdoc
     */
    public function findByMany(array $ids)
    {
        $query = $this->model->query();

        return $query->whereIn("id", $ids)->get();
    }

    /**
     * @inheritdoc
     */
    public function clearCache()
    {
        return true;
    }
}
