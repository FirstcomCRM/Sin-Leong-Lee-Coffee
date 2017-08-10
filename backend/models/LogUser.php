<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log_user".
 *
 * @property integer $id
 * @property string $name
 * @property string $role
 * @property string $date
 * @property string $time_in
 * @property string $time_out
 */
class LogUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'role', 'date', 'time_in', 'time_out'], 'required'],
            [['time_in', 'time_out'], 'safe'],
            [['name', 'role', 'date'], 'string', 'max' => 255],
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
            'time_in' => 'Time In',
            'time_out' => 'Time Out',
        ];
    }
}
