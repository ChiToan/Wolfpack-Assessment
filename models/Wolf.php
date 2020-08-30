<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Wolf for table "wolf"
 * @package app\models
 *
 * @property integer $ID
 * @property string $name
 * @property string $gender
 * @property integer $birthdate
 * @property double $latitude
 * @property double $longitude
 *
 *
 */
class Wolf extends ActiveRecord
{

    public function getPack()
    {
        return $this->hasOne(Pack::class, ['pack_id' => 'id']);
    }

    public function rules()
    {
        return [
            // the name of the wolf is required
            ['name', 'required'],
            // validate name and gender to be string
            [['name', 'gender'], 'string'],
            // validate birthdate to be a date
            ['birthdate', 'date'],
            [['latitude', 'longitude'], 'double']
        ];
    }
}