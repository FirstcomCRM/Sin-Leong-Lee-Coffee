<?php
namespace common\components;

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
}
?>
