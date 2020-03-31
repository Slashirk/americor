<?php
namespace common\widgets\Pagination;

use yii\base\Widget;

class Pagination extends Widget
{
    /** @var int */
    public $start;

    /** @var int */
    public $end;

    /** @var int */
    public $max;

    /** @var  */
    public $prev;

    public function run()
    {
        return $this->render('main', [
            'start' => $this->start,
            'end' => $this->end,
            'max' => $this->max,
            'prev' => $this->prev
        ]);
    }
}
