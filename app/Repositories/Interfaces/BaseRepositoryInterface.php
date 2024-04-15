<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function pagination(
        array $columns = ['*'], 
        array $condition = [], 
        array $join = [], 
        array $extend =[],
        int $perPages = 15,
        array $relation =[],
        array $orderBy =[],
    );
    public function find($id);
    public function findById(int $id, array $columns = ['*'], array $relation = []);

    public function findWhere(array $collectWhere, array $columns = ['*'], array $relation = []);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($payload = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);
    public function updateByWhereIn(array $whereIn = [], $attributes = [] );

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    public function createTranslatePivot($model, array $attributes =[]);
}