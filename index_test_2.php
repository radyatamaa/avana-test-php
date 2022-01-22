<!DOCTYPE html>
<html>
<body>

<?php

    function InitialErrorHandling($index){

    } 


    if(isset($_FILES['filename'])){
        $nama = $_FILES['filename']['name'];
        if($nama != null){
            require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
            require('spreadsheet-reader-master/SpreadsheetReader.php');

            $target_dir = "uploads/".basename($_FILES['filename']['name']);
  
            move_uploaded_file($_FILES['filename']['tmp_name'],$target_dir);
          
            $Reader = new SpreadsheetReader($target_dir);
            $fields = [];
            $data = [];
            $errorHandlingMessage = [];
            foreach ($Reader as $Key => $Row){
                if($Key == 0)  {
                    foreach ($Row as $idx => $val){
                        array_push($fields,$val);
                    }
                    continue;
                }

                $arrayData = [];
                foreach ($Row as $idx => $val){
                    array_push($arrayData,$val);
                }

                array_push($data,$arrayData);
               
            }

            foreach($data as $index => $val){
                foreach($val as $idx => $val2){
                    if ((is_null($val2) || empty($val2)) && strpos($fields[$idx], '*') == true){
                        $error = "Missing value in " . str_replace("*","",$fields[$idx]);
                        if (!isset($errorHandlingMessage[$index + 2])){
                            $errorHandlingMessage[$index + 2] = $error;
                        }else{
                            $errorHandlingMessage[$index + 2] .= ", " . $error;
                        }
                    }

                    if ((strpos($val2, ' ') == true) && (strpos($fields[$idx], '#') == true || strpos($fields[$idx], 'Field_B') == true)){
                        $error = str_replace("#","",$fields[$idx]) . " should not contain any space";
                        if (!isset($errorHandlingMessage[$index + 2])){
                            $errorHandlingMessage[$index + 2] = $error;
                        }else{
                            $errorHandlingMessage[$index + 2] .= ", " . $error;
                        }
                    }
                }
            } 


            if(count($errorHandlingMessage) > 0){
                foreach($errorHandlingMessage as $row => $val){
                    $errorHandling[$row] = array(
                        'Row' => $row,
                        'Error' => $val,
                    );
                }
                echo json_encode($errorHandling);
            }
           



            
        }
    }
    

?>

<p>Click on the "Choose File" button to upload a file:</p>

<form action="" enctype="multipart/form-data" method="POST">
  <input type="file" id="myFile" name="filename" accept=".xls,.xlsx">
  <input type="submit">
</form>


</body>
</html>
