<?php

namespace App\Helpers;

use App\Exceptions\Custom\ModelUpdatingException;

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
     * @throws \App\Exceptions\Custom\ModelUpdatingException
     */
    public static function updateOrFail(int $id, array $attributes): bool
    {
        $model = static::findOrFail($id)->fill($attributes);

        if ($model->update() === false) {
            throw new ModelUpdatingException($id, get_class($model));
        }

        return true;
    }
}
