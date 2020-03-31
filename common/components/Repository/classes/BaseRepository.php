<?php

namespace common\components\Repository\classes;

use common\components\Repository\interfaces\RepositoryInterface;
use common\components\Repository\traits\RepositoryLinksTrait;
use common\components\Repository\traits\RepositoryRelationsTrait;
use common\components\Repository\traits\RepositorySingleLevelRelationsTrait;
use common\components\Repository\traits\RepositoryTrait;

/**
 * Class BaseRepository
 *
 * @property array $relations
 * @package common\services\Repository
 */
abstract class BaseRepository implements RepositoryInterface
{
    use RepositoryRelationsTrait;
    use RepositoryTrait;
    use RepositoryLinksTrait;
    use RepositorySingleLevelRelationsTrait;
}
