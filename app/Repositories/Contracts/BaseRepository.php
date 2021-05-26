<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepository
 *
 * @author tuannq@vnext.com.vn
 *
 * @package App\Repositories
 */
interface BaseRepository
{
    /**
     * @param int $id
     * @return $model
     */
    public function find($id, $is = false);

    /**
     * Return a collection of all elements of the resource
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();

    public function findWhere($id, string $column);

    /**
     * Paginate the model to $perPage items per page
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 25);

    /**
     * Create a resource
     * @param  $data
     * @return Model
     */
    public function create($data);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    public function updateData(string $column, $id, $data);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);


    /**
     * Find a resource by the given slug
     * @param string $slug
     * @return $model
     */
    public function findBySlug($slug, $status = false);

    /**
     * Find a resource by the given slug
     * @param string $email
     * @return $model
     */
    public function findByEmail($email);

    /**
     * Find a resource by an array of attributes
     * @param array $attributes
     * @return $model
     */
    public function findByAttributes(array $attributes);

    /**
     * Return a collection of elements who's ids match
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByMany(array $ids);

    /**
     * Get resources by an array of attributes
     * @param array $attributes
     * @param null|string $orderBy
     * @param string $sortOrder
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByAttributes(array $attributes, $orderBy = null, $sortOrder = 'asc');

    /**
     * Clear the cache for this Repositories' Entity
     * @return bool
     */
    public function clearCache();
}
