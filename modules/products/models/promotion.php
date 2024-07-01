<?php

class ProductsModelsPromotion extends FSModels
{
    function __construct()
    {
        parent::__construct();
        $this->limit = 30;
    }
}
