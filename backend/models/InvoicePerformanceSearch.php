<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\InvoicePerformance;
use yii\data\Pagination;
/**
 * InvoicePerformanceSearch represents the model behind the search form about `backend\models\InvoicePerformance`.
 */
class InvoicePerformanceSearch extends InvoicePerformance
{
    /**
     * @inheritdoc
     */
     public $year_to;
     public $month_to;
     public $year_from;
     public $month_from;
     public $type_l;

    public function rules()
    {
        return [
            [['id', 'invoice_id'], 'integer'],
            [['customer_name', 'invoice_no', 'date', 'average_cost', 'job_no', 'sales_person', 'customer_card_id', 'invoice_item_code','item_code','item_name','item_abbr', 'year_to','month_to','year_from','month_from','type_l'], 'safe'],
            [['quantity', 'amount'], 'number'],
        //    [['customer_name'],'required']

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
        $query = InvoicePerformance::find();

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
            'quantity' => $this->quantity,
            'amount' => $this->amount,
            'invoice_id' => $this->invoice_id,
        ]);

        $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'average_cost', $this->average_cost])
            ->andFilterWhere(['like', 'job_no', $this->job_no])
            ->andFilterWhere(['like', 'sales_person', $this->sales_person])
            ->andFilterWhere(['like', 'customer_card_id', $this->customer_card_id])
            ->andFilterWhere(['like', 'invoice_item_code', $this->invoice_item_code])
            ->andFilterWhere(['like', 'item_code',$this->item_code])
            ->andFilterWhere(['like', 'item_name',$this->item_name]);
        return $dataProvider;
    }

    public function performance_list($month = null,$year = null)
    {

        $sql = "SELECT b.item_code, b.item_name, a.customer_name, a.invoice_no, c.month, a.quantity, a.amount, a.average_cost,a.job_no, a.sales_person, a.customer_card_id
                FROM invoice_performance a
                LEFT JOIN invoice_quantity b ON b.item_code = a.invoice_item_code
                LEFT JOIN invoice c ON c.id = b.invoice_id";

        if ($year != null && $month != null) {

            $sql .= " where c.month = '".$month.' - '.$year."'";
        }

        return $result = Yii::$app->db->createCommand($sql)->queryAll();
    }


//edr
    public function quantity_list($params){
      $query = InvoicePerformance::find();

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


      if (!empty($this->month_from)) {
        $ym_from = $this->month_from.'-'.$this->year_from;
        $ym_to = $this->month_to.'-'.$this->year_to;
        $date_from = date('Y-m-01', strtotime($ym_from));
        $date_to = date('Y-m-t', strtotime($ym_to));

      }else{
        $date_from = '';
        $date_to = '';
      }
      if (!empty($this->month_from)) {

        $custFileDistinct = InvoicePerformance::find()->select(['customer_name'])->distinct()
                      ->andFilterWhere(['between','date',$date_from,$date_to])
                    //  ->andFilterWhere(['like', 'customer_name', $this->customer_name])
                      ->andFilterWhere(['customer_name'=> $this->customer_name])
                      ->andFilterWhere(['like', 'item_code',$this->item_code])
                      ->asArray()
                     ->all();
      }else{
          $custFileDistinct = InvoicePerformance::find()->where(['id'=>0])->all();
      }


      return $custFileDistinct;
    }

    public function perform_list($params){
      $query = InvoicePerformance::find();

      // add conditions that should always apply here

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
      ]);

      if (!$this->validate()) {

      }
       $this->load($params);

       $ym_from = $this->month_from.'-'.$this->year_from;
       $ym_to = $this->month_to.'-'.$this->year_to;
       $date_from = date('Y-m-01', strtotime($ym_from));
       $date_to = date('Y-m-t', strtotime($ym_to));


       $query->andFilterWhere(['like', 'customer_name', $this->customer_name])
              ->andFilterWhere(['between','date',$date_from,$date_to]);

       return $dataProvider;


    }

}
