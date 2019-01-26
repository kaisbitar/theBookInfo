<?php

namespace App;

use App\Words;

class Letter extends Words
{
    public $word;

    public function __construct($word)
    {
        $this->word = $word;
    }
}
