<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
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
