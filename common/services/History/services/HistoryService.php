<?php

namespace common\services\History\services;

use common\services\History\repositories\HistoryRepository;

class HistoryService
{
    /** @var HistoryRepository */
    private $historyRepository;

    /**
     * HistoryService constructor.
     *
     * @param HistoryRepository $historyRepository
     */
    public function __construct(
        HistoryRepository $historyRepository
    ) {
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param int $start
     * @param int $limit
     *
     * @return array
     */
    public function getListOrderedById(int $start, int $limit = 20): array
    {
        return [
            $this->historyRepository->getListOrderedById($start, $limit),
            $this->historyRepository->getListPrevId($start, $limit),
            $this->historyRepository->getListMaxId()
        ];
    }

}
