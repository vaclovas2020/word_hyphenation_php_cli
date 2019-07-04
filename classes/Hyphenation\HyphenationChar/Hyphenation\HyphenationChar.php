<?php 

namespace Hyphenation;

class HyphenationChar{
    protected $char;
    protected $count;

    public function __construct(string $char = '', int $count = 0){
        $this->char = $char;
        $this->count = $count;
    }

    public function getChar(): string{
        return $this->char;
    }

    public function setCount(int $count){
        $this->count = $count;
    }

    public function getCount(): int{
        return $this->count;
    }
}