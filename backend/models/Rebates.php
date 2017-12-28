<?php

namespace backend\models;

use Yii;
use backend\models\RebateReport;

/**
 * This is the model class for table "rebates".
 *
 * @property integer $id
 * @property string $date_uploaded
 * @property string $total
 */
class Rebates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $file;
    public static function tableName()
    {
        return 'rebates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['date_uploaded'], 'required'],
            [['date_uploaded'], 'safe'],
            [['total'], 'number'],
            [['file'],'file','skipOnEmpty'=>false, 'mimeTypes'=>'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
               'wrongMimeType'=>'Invalid file format. Please use .xls or .xlsx',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_uploaded' => 'Date Uploaded',
            'total' => 'Total',
        ];
    }

    public function upload(){
        $filename =  time().$this->file;
        $this->file->saveAs('uploads/rebates/'.$filename);
        return $filename;
    }

    public function importExcel($filename){
      ini_set('max_execution_time', 420);
      ini_set("memory_limit", "512M");
      $inputFile = 'uploads/rebates/'.$filename;

      try{
          $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
          $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
          $objPHPExcel = $objReader->load($inputFile);
      } catch (Exception $e) {
          die('Error');
      }

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      for ($row=11; $row < $highestRow ; $row++) {
          $rowData = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

          if (!empty($rowData[0][1])) {
            $customer = $rowData[0][1];
          }

          $data = $image = substr($rowData[0][2], 0, 2);
          if ($data == 'CN' || $data == 'R1') {
            $rebate = new RebateReport();
            $rebate->customer =   $customer;
            $rebate->rebates_id = $this->id;
            $rebate->class=$rowData[0][2];
            $dateInput = explode('/',$rowData[0][3]);
            if (empty($rowData[0][3]) ) {
              $rebate = null;
              continue;
            }else{
              $rebate->date = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
            }
            $rebate->quantity = $rowData[0][4];
            $rebate->account = $rowData[0][5];
            $rebate->description = $rowData[0][6];
            $rebate->amount = $rowData[0][7];
            $rebate->tax = $rowData[0][8];
            $rebate->job_no = $rowData[0][9];
            $rebate->save(false);
          }else{
            continue;
          }

          if (empty($rowData[0][3]) )  {
            continue;
          }


      }

    }

}
