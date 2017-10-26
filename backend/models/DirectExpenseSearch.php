<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DirectExpense;

/**
 * DirectExpenseSearch represents the model behind the search form about `backend\models\DirectExpense`.
 */
class DirectExpenseSearch extends DirectExpense
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'expense_type'], 'integer'],
            [['date', 'date_created','customer_name'], 'safe'],
            [['expenses'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DirectExpense::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'expense_type' => $this->expense_type,
            'date' => $this->date,
            'expenses' => $this->expenses,
            'date_created' => $this->date_created,
            'customer_name'=>$this->customer_name,
        ]);

        return $dataProvider;
    }
}
