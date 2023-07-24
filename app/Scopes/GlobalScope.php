<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GlobalScope implements Scope
{
    protected $institute_id;

    public function __construct($institute_id)
    {
        $this->institute_id = $institute_id;
    }

    public function apply(Builder $builder, Model $model)
    {

        echo "<pre>";
        print_r($this->institute_id);
        echo "</pre>";
        exit;

//        $builder->where('age', '>', 200);
    }
}
