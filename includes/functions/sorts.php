<?php

function increase_Sort($unsorted, $column) { 
    $sorted = $unsorted; 
    for ($i=0; $i < sizeof($sorted)-1; $i++) { 
      for ($j=0; $j <sizeof($sorted)-1-$i; $j++) 
        if ($sorted[$j][$column] > $sorted[$j+1][$column]) { 
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
    for ($j=0; $j <sizeof($sorted)-1-$i; $j++) 
      if (((int)$sorted[$j][$like]-(int)$sorted[$j][$dislike])/((int)$sorted[$j][$like]+(int)$sorted[$j][$dislike]) < ((int)$sorted[$j+1][$like]-(int)$sorted[$j+1][$dislike])/((int)$sorted[$j+1][$like]+(int)$sorted[$j+1][$dislike])) { 
        $tmp = $sorted[$j]; 
        $sorted[$j] = $sorted[$j+1]; 
        $sorted[$j+1] = $tmp; 
      } 
  } 
  return $sorted; 
}


?>