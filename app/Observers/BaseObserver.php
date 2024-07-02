<?php

namespace App\Observers;

use App\Utils\AuthHelpers;
use Illuminate\Database\Eloquent\Model;

abstract class BaseObserver
{
    public function creating(Model $model): void
    {
        $model['created_by'] = AuthHelpers::getUserId();
    }

    public function saving(Model $model): void
    {
        $model['updated_by'] = AuthHelpers::getUserId();
    }

    public function deleted(Model $model): void
    {
        $model['deleted_by'] = AuthHelpers::getUserId();
        $model->save();
    }
}
