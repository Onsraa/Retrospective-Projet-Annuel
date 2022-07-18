<?php

function increase_Sort($unsorted, $column) { 
    $sorted = $unsorted; 
    for ($i=0; $i < sizeof($sorted)-1; $i++) { 
      for ($j=0; $j <sizeof($sorted)-1-$i; $j++) 
        if ($sorted[$j][$column] > $sorted[$j+1][$column] || $sorted[$j][$column] == $sorted[$j+1][$column]) { 
          $tmp = $sorted[$j]; 
          $sorted[$j] = $sorted[$j+1]; 
          $sorted[$j+1] = $tmp; 
        } 
    } 
    return $sorted; 
}

function decrease_Sort($unsorted, $column) { 
    $sorted = $unsorted; 
    for ($i=0; $i < sizeof($sorted)-1; $i++) { 
      for ($j=0; $j <sizeof($sorted)-1-$i; $j++) 
        if ($sorted[$j][$column] < $sorted[$j+1][$column]) { 
          $tmp = $sorted[$j]; 
          $sorted[$j] = $sorted[$j+1]; 
          $sorted[$j+1] = $tmp; 
        }
    } 
    return $sorted; 
}

function ratio_Sort($unsorted, $like, $dislike) { 
  $sorted = $unsorted; 
  for ($i=0; $i < sizeof($sorted)-1; $i++) { 
    for ($j=0; $j <sizeof($sorted)-1-$i; $j++){ 
      if(
        $sorted[$j][$like] != 0 &&
        $sorted[$j][$dislike] != 0 && 
        $sorted[$j+1][$like] != 0 &&
        $sorted[$j+1][$dislike] != 0){
          if (
            ((int)$sorted[$j][$like]-(int)$sorted[$j][$dislike])/((int)$sorted[$j][$like]+(int)$sorted[$j][$dislike]) < 
            ((int)$sorted[$j+1][$like]-(int)$sorted[$j+1][$dislike])/((int)$sorted[$j+1][$like]+(int)$sorted[$j+1][$dislike])){
              $temp = $sorted[$j];
              $sorted[$j] = $sorted[$j+1];
              $sorted[$j+1] = $temp;
          } 
      }
      else if(
        $sorted[$j][$like] != 0 &&
        $sorted[$j][$dislike] != 0
      ){
        $temp = $sorted[$j];
        $sorted[$j] = $sorted[$j+1];
        $sorted[$j+1] = $temp;
      }
      else{
        $temp = $sorted[$j+1];
        $sorted[$j+1] = $sorted[$j];
        $sorted[$j] = $temp;
      }
    } 
  }
  return $sorted; 
}


?>