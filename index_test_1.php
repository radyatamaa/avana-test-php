<?php
function Test1($params1,$params2) {
    $index = 0;
    for ($x = $params2; $x <= strlen($params1); $x++) {
        if($params1[$params2] !== '('){
            echo 'invalid';
            break;
        }       
        switch ($params1[$x]) {
            case "(":
              $index++;
              break;
            case ")":
              $index--;
              if($index === 0){
                  $x;
                  return $x;
              }
              break;
          }
    } 
    return $x;
}
$inputString = "a (b c (d e (f) g) h) i (j k)";
$inputInt = 2;
$test1 = Test1($inputString,$inputInt);

echo 'Result is '.$test1;
?>