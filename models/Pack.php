<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 *
 *
 * @property integer $ID
 * @property string $name
 * @property-read mixed $wolves
 */
class Pack extends ActiveRecord
{
    public function getWolves()
    {
        return $this->hasMany(Wolf::class, ['id' => 'wolf_id'])
            ->viaTable('wolfPack', ['pack_id' => 'id']);
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