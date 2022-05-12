<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ModelDeletionException;

trait DeleteOrFail
{
    /**
     * Instantiate a new model instance from the model implementing this trait.
     *
     * @return Model
     */
    private static function model(): Model
    {
        return new (get_class());
    }

    /**
     * Find a model by id, remove the model into the database,
     * otherwise it throws an exception.
     *
     * @param  int  $id
     * @return Model
     *
     * @throws \App\Exceptions\ModelDeletionException
     */
    public static function deleteOrFail(int $id): Model
    {
        $model = self::model()->findOrFail($id);

        if ($model->delete() === false) {
            throw new ModelDeletionException($id, get_class());
        }

        return $model;
    }
}
