<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Lab No. 6 - Temp. Converter</title>
</head>
<body>

<?php

// to prevent errors from showing up do to unset variables at first load of homepage
error_reporting(0);

// function to calculate converted temperature
function convertTemp($temp, $unit1, $unit2)
{
    // switch statement to see which unit the temp to be converted is set to
    // Then nested cases check which converted temp unit the user set
    // then based on each case a formula is applied and sets the $convertedTemp variable to be returned


    switch ($unit1) {
        case 'celsius':
            switch ($unit2) {

                case 'fahrenheit':
                    $convertedTemp = $temp * 9/5 + 32;
                    break;

                case 'kelvin':
                    $convertedTemp = $temp + 273.15;
                    break;                        
            }
        break;                   

        case 'kelvin':
            switch ($unit2) {

                case 'fahrenheit':
                    $convertedTemp = $temp * 9/5 - 459.67;
                    break;

                case 'celsius':
                    $convertedTemp = $temp - 273.15;
                    break;
                                
            } 
        break;     

        case 'fahrenheit':
            switch ($unit2) {

                case 'celsius':
                    $convertedTemp = ($temp - 32) * 5/9;
                    break;

                case 'kelvin':
                    $convertedTemp = ($temp + 459.67) * 5/9;
                    break;             
            }
        break;
                  
        
        
    }
    // echo $convertedTemp; for testing and dev
    return $convertedTemp;

    // conversion formulas
    // Celsius to Fahrenheit = T(°C) × 9/5 + 32
    // Celsius to Kelvin = T(°C) + 273.15
    // Fahrenheit to Celsius = (T(°F) - 32) × 5/9
    // Fahrenheit to Kelvin = (T(°F) + 459.67)× 5/9
    // Kelvin to Fahrenheit = T(K) × 9/5 - 459.67
    // Kelvin to Celsius = T(K) - 273.15    

} // end function

// Logic to check for POST and grab data from $_POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // variable declarations for error handling.

    $flag = false;
    $errors = [];
    

    


    // is the temp a numeric? if not, add error to bucket and set $flag to true
    if (isset($_POST['originaltemp'])){
        $originalTemperature = $_POST['originaltemp'];
            if (!(is_numeric($originalTemperature))) {
                array_push($errors,"Please input only numbers to be converted");
                $flag = true;
                               
            }
            
        // echo $originalTemperature; for testing and dev
    }

    // was a unit selected rather then left on the default drop down selection?

    if (isset($_POST['originalunit'])){
        $originalUnit = $_POST['originalunit'];
        if ($originalUnit == '--Select--') {          
            array_push($errors,"Please set type of temperature unit");
            $flag = true;      
             
        }
        // echo $originalUnit; for testing and dev
    }

    // was a unit selected rather then left on the default drop down selection?

    if (isset($_POST['conversionunit'])){
        $conversionUnit = $_POST['conversionunit'];
        if ($conversionUnit == '--Select--') {                       
            array_push($errors,"Please set type of temperature unit to convert to");
            $flag = true; 
        }
         // echo $conversionUnit; for testing and dev
    }

    // checks if the conversion unit type and the original unit type are the same
    // if they are, add an error to the bucket and trigger the flag to true

    if ($originalUnit == $conversionUnit){
        array_push($errors,"Please make sure conversion unit type is different from original type");
        $flag = true; 
    }
    
    // $flag is an on off switch for the error bucket.
    // If any errors present, loop and echo them out. 
    // Set convertedTemp to empty since when an error is created it would echo weird stuff in text field
    // for converted temp 

    if ($flag){
        foreach ($errors as $error) {
        echo "<strong>$error</strong>";
        echo "<br>";
        $convertedTemp = "";
        }        
    }

    // function call to convert temps

    else {
        $convertedTemp = convertTemp($originalTemperature, $originalUnit, $conversionUnit);
    }
          
       
    
   
    
    
    
} // end if

?>
<!-- Form starts here -->
<h1>Temperature Converter</h1>
<h4>CTEC 127 - PHP with SQL 1</h4>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <div class="group">
        <label for="temp">Temperature</label>
        <input type="text" value="<?php if (isset($_POST['originaltemp'])) {
    echo $_POST['originaltemp'];
}
?>" name="originaltemp" size="14" maxlength="7" id="temp">

        <select name="originalunit">
            <option value="--Select--" <?php if($originalUnit == "--Select--") echo 'selected="selected"';?>>--Select--</option>
            <option value="celsius" <?php if($originalUnit == "celsius") echo 'selected="selected"';?>>Celsius</option>
            <option value="fahrenheit" <?php if($originalUnit == "fahrenheit") echo 'selected="selected"';?>>Farenheit</option>
            <option value="kelvin" <?php if($originalUnit == "kelvin") echo 'selected="selected"';?>>Kelvin</option>
        </select>
    </div>

    <div class="group">
        <label for="convertedtemp">Converted Temperature</label>
        <input type="text" 
        value="<?php echo $convertedTemp; ?>"
        name="convertedtemp" size="14" maxlength="7" id="convertedtemp" readonly>

        <select name="conversionunit">
            <option value="--Select--" <?php if($conversionUnit == "--Select--") echo 'selected="selected"';?>>--Select--</option>
            <option value="celsius" <?php if($conversionUnit == "celsius") echo 'selected="selected"';?>>Celsius</option>
            <option value="fahrenheit" <?php if($conversionUnit == "fahrenheit") echo 'selected="selected"';?>>Farenheit</option>
            <option value="kelvin" <?php if($conversionUnit == "kelvin") echo 'selected="selected"';?>>Kelvin</option>
        </select>
    </div>
    <input type="submit" value="Convert"/>
    

</form>
</body>
</html>