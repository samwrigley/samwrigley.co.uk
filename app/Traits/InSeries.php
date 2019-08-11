<?php

namespace App\Traits;

trait InSeries
{
    public function next(): ?Article
    {
        return $this->series->articles->find($this->id + 1);
    }

    public function previous(): ?Article
    {
        return $this->series->articles->find($this->id - 1);
    }
}
