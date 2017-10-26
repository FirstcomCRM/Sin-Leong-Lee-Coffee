<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "account_list".
 *
 * @property integer $id
 * @property string $account
 * @property string $account_details
 */
class AccountList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'account_details'], 'required'],
            [['account'],'unique'],
            [['account'], 'string', 'max' => 20],
            [['account_details'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => 'Account',
            'account_details' => 'Account Details',
        ];
    }
}
