<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

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
 * @property-read mixed $pack
 * @property double $pack_id
 *
 *
 */
class Wolf extends ActiveRecord
{

    public function getPack()
    {
        return $this->hasMany(Pack::class, ['id' => 'pack_id'])
            ->viaTable('wolfPack', ['wolf_id'=>'id']);
    }

    public function beforeDelete()
    {
        if ($this->getPack()->count()==1) {
            throw new Exception("This wolf is the only wolf of its pack, please remove the pack first.");
        }
        return parent::beforeDelete();
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
            // validate location coordinates as doubles within their ranges
            ['latitude', 'number', 'min' =>-90, 'max' => 90],
            ['longitude', 'number', 'min' =>-180, 'max' => 180]
        ];
    }
}