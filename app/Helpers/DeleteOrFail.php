<?php

namespace App\Helpers;

use App\Exceptions\ModelDeletion;

trait DeleteOrFail
{
    /**
     * Find a model by id, remove the model into the database,
     * otherwise it throws an exception.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \App\Exceptions\ModelUpdating
     */
    public static function deleteOrFail(int $id): bool
    {
        $model = static::findOrFail($id);

        if ($model->delete() === false) {
            throw new ModelDeletion($id, get_class($model));
        }

        return true;
    }
}
