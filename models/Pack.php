<?php

namespace app\models;

use yii\db\ActiveRecord;

class Pack extends ActiveRecord
{
    public function getWolves()
    {
        return $this->hasMany(Wolf::class, ['id' => 'pack_id']);
    }

    public function rules()
    {
        return [
            // the name of the wolf is required
            ['name', 'required'],
            // validate name and gender to be string
            ['name', 'string'],
        ];
    }
}