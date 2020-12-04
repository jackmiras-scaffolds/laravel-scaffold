<?php

namespace App\Helpers;

use App\Exceptions\ModelUpdating;

trait UpdateOrFail
{
    /**
     * Find a model by id, fill the model with an array of attributes, update
     * the model into the database, otherwise it throws an exception.
     *
     * @param  int  $id
     * @param  array  $attributes
     * @return bool
     *
     * @throws \App\Exceptions\ModelUpdating
     */
    public static function updateOrFail(int $id, array $attributes): bool
    {
        $model = static::findOrFail($id)->fill($attributes);

        if ($model->update() === false) {
            throw new ModelUpdating($id, get_class($model));
        }

        return true;
    }
}
