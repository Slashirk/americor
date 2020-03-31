<?php

namespace common\components\Repository\interfaces;

interface RepositoryInterface
{
    /**
     * @param array $condition
     *
     * @return mixed
     */
    public function findOne($condition = []);

    /**
     * @param array $condition
     *
     * @return mixed
     */
    public function findAll($condition = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function add(array $attributes = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes = []);

    /**
     * @param       $model
     * @param array $attributes
     *
     * @return bool
     */
    public function load($model, array $attributes = []): bool;

    /**
     * @param $model
     *
     * @return bool
     */
    public function save($model);

    /**
     * @param       $model
     * @param bool  $runValidation
     * @param array $attributes
     *
     * @return bool
     */
    public function savePartial($model, bool $runValidation, array $attributes): bool;

    /**
     * @param $model
     *
     * @return bool
     */
    public function delete($model): bool;

    /**
     * @param array $condition
     *
     * @return bool
     */
    public function deleteAll($condition = []): bool;

    /**
     * @param array $condition
     *
     * @return array|null
     */
    public function search($condition = []);
}
