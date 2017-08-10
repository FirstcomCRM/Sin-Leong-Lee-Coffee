<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log_event".
 *
 * @property integer $id
 * @property string $name
 * @property string $role
 * @property string $date
 * @property string $module
 * @property string $event
 */
class LogEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'role', 'date', 'module', 'event'], 'required'],
            [['date'], 'safe'],
            [['name', 'role', 'module', 'event'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'role' => 'Role',
            'date' => 'Date',
            'module' => 'Module',
            'event' => 'Event',
        ];
    }
}
