<?php

namespace App;

use App\Word;

class Letter extends Word
{
    public $char;
    public $index;

    public function __construct($char, $index)
    {
        $this->char = $char;
        $this->index = $index;

        return $this;
    }
}
