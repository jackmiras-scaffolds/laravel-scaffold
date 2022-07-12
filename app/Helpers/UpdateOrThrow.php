<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ModelUpdatingException;

trait UpdateOrThrow
{
    /**
     * Instantiate the model implementing this trait by the model's class name.
     *
     * @return Model
     */
    private static function model(): Model
    {
        return new (get_class());
    }

    /**
     * Find a model by id, fill the model with an array of attributes, update
     * the model into the database, otherwise it throws an exception.
     *
     * @param  int  $id
     * @param  array  $attributes
     * @return Model
     *
     * @throws \App\Exceptions\ModelUpdatingException
     */
    public static function updateOrThrow(int $id, array $attributes): Model
    {
        $model = self::model()->findOrFail($id)->fill($attributes);

        if ($model->update() === false) {
            throw new ModelUpdatingException($id, get_class());
        }

        return $model;
    }
}
