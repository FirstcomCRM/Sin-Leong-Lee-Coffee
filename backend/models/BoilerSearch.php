<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Boiler;

/**
 * BoilerSearch represents the model behind the search form about `backend\models\Boiler`.
 */
class BoilerSearch extends Boiler
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['customer', 'bolter_no', 'invoice_no', 'pur_date', 'pur_cost', 'acc_depn', 'year'], 'safe'],
            [['cost', 'depn', 'nbv'], 'number'],
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
        $query = Boiler::find();

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
            'cost' => $this->cost,
            'year' => $this->year,
            'depn' => $this->depn,
            'nbv' => $this->nbv,
        ]);

        $query->andFilterWhere(['like', 'customer', $this->customer])
            ->andFilterWhere(['like', 'bolter_no', $this->bolter_no])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'pur_date', $this->pur_date])
            ->andFilterWhere(['like', 'pur_cost', $this->pur_cost])
            ->andFilterWhere(['like', 'acc_depn', $this->acc_depn]);

        return $dataProvider;
    }
}
