<?php

namespace common\components\Repository\traits;

use common\components\Repository\exceptions\ErrorOnSaveException;
use common\components\Repository\exceptions\ModelNotFoundException;
use common\components\Repository\interfaces\SearchModelInterface;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\QueryBuilder;

/**
 * Trait RepositoryTrait
 * @package common\services\Repository\traits
 */
trait RepositoryTrait
{
    /** @var ActiveRecord */
    public static $modelClass;

    /** @var Model|SearchModelInterface */
    public static $modelSearch;

    /**
     * @param array $condition
     *
     * @return ActiveRecord
     */
    public function findOrNew($condition = [])
    {
        if (empty($condition)) {
            if (!is_array($condition)) {
                $condition = [];
            }
            return $this->add($condition);
        }

        return $this->findOne($condition) ?? $this->add($condition);
    }

    /**
     * @param array $attributes
     *
     * @return ActiveRecord
     * @throws ErrorOnSaveException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function create(array $attributes = [])
    {
        $model = $this->add($attributes);
        $this->save($model);

        return $model;
    }

    /**
     * @param Model $model
     * @param array $attributes
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function load($model, array $attributes = []): bool
    {
        if (empty($attributes)) {
            return true;
        }

        return $model->load([$model->formName() => $attributes]);
    }

    /**
     * @param int|array $condition
     *
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findOneOrFail($condition = [])
    {
        $model = $this->findOne($condition);
        if (null === $model) {
            throw new ModelNotFoundException($condition);
        }

        return $model;
    }

    /**
     * @param array $condition
     *
     * @throws ModelNotFoundException
     */
    public function existsOrFail($condition = [])
    {
        if (!$this->exists($condition)) {
            throw new ModelNotFoundException($condition);
        }
    }

    /**
     * @param array $condition
     *
     * @return bool
     */
    public function exists($condition = [])
    {
        return $this->find()->andWhere($condition)->exists();
    }

    /**
     * @param array $attributes
     *
     * @return ActiveRecord
     */
    public function add(
        array $attributes = []
    ) {
        /** @var ActiveRecord $model */
        $model = new static::$modelClass();
        $model->setAttributes($attributes);

        return $model;
    }

    /**
     * @return ActiveQuery
     */
    public function find()
    {
        return static::$modelClass::find();
    }

    /**
     * @param array|int $condition
     *
     * @return null|ActiveRecord
     */
    public function findOne($condition = [])
    {
        if (!is_array($condition)) {
            return static::$modelClass::findOne((int)$condition);
        }

        return static::$modelClass::find()->where($condition)->one();
    }

    /**
     * @param array $condition
     *
     * @return ActiveRecord[]|null
     */
    public function findAll($condition = [])
    {
        return static::$modelClass::find()
            ->where($condition)
            ->all();
    }

    /**
     * @param array $condition
     *
     * @return int
     */
    public function count($condition = [])
    {
        return (int)static::$modelClass::find()
            ->where($condition)
            ->count();
    }

    /**
     * @param $model
     *
     * @return ActiveRecord
     * @throws ErrorOnSaveException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function save($model)
    {
        /** @var $model ActiveRecord */
        if (!$model->save()) {
            throw new ErrorOnSaveException($model);
        }

        return $model;
    }

    /**
     * @param ActiveRecord $model
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete($model): bool
    {
        $result = $model->delete();

        return $result;
    }

    /**
     * @param array $condition
     *
     * @return bool
     * @throws ErrorOnSaveException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\di\NotInstantiableException
     */
    public function deleteAll($condition = []): bool
    {
        $result = static::$modelClass::deleteAll($condition);
        return $result;
    }

    /**
     * @param       $attributes
     * @param array $condition
     *
     * @return bool
     */
    public function updateAll($attributes, $condition = []): bool
    {
        $result = static::$modelClass::updateAll($attributes, $condition);

        return $result;
    }

    /**
     * @param array $condition
     *
     * @return array|null
     */
    public function search($condition = [])
    {
        /** @var SearchModelInterface $modelSearch */
        $modelSearch = new static::$modelSearch();
        $provider = $modelSearch->search($condition);
        return [$modelSearch, $provider];
    }

    /**
     * @param ActiveRecord $model
     * @param bool         $runValidation
     * @param array        $attributes
     *
     * @return bool
     */
    public function savePartial($model, bool $runValidation, array $attributes): bool
    {
        return $model->save($runValidation, $attributes);
    }

    /**
     * @return mixed
     */
    public function getSearchModelInstance()
    {
        return new static::$modelSearch();
    }
}
