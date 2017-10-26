<?php
namespace common\components;
use backend\models\AssetType;
/*
Title: retrieve.php
Date: 2017-08-02
Description: Use to retrieve information from various models, such as username etc
Developer: EDR
*/

Class Retrieve{

  //edr default numeric formatting
public static function retrieveFormat($number){
    return number_format($number,2);
  }

public static function retrieveAsset($id){
  $data = AssetType::find()->where(['id'=>$id])->one();
  if (!empty($data)) {
    return $data->asset;
  }else{
    return $data = null;
  }
}

}
?>
