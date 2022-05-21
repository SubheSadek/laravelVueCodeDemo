<?php

namespace App\Http\Controllers\Exel;

class ExelService
{
    private $exelQuery;
    public function __construct(ExelQuery $exelQuery)
    {
        $this->exelQuery = $exelQuery;
    }
    public function exelMethod(){
        return $this->exelQuery->exelMethodQuery();
    }

}
