
<!DOCTYPE html>
<html>
    <?php

$hasSelectedRestaurant = false;
$selectedRestaurant;
$saveSuccess = false;

$xmlFile = 'restaurant_reviews.xml';

if (isset($_POST['submitSave'])) {
    //o    pen xml then make modifications then save
    if (file_exists($xmlFile)) {
        
        $xml = simplexml_load_file($xmlFile);
        
        //m        ake modifications
        foreach ($xml as $resto) {
            if ($_POST['drpRestaurants'] == $resto->Name) {
                $resto->Summary = $_POST['txtSummary'];
                $resto->Rating  = intval($_POST['drpRating']);
            }
            
        }
        
        $xml->asXML($xmlFile);
        
        $saveSuccess = true;
        
        $hasSelectedRestaurant = true;
        
        foreach ($xml as $resto) {
            if ($_POST['drpRestaurants'] == $resto->Name) {
                $selectedRestaurant = $resto;
            }
        }
    }
    
    
    else {
        exit('Failed to open test.xml.');
    }
} else {
    if (!isset($_POST['drpRestaurants']) || $_POST['drpRestaurants'] == -1) {
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
        } else {
            exit('Failed to open test.xml.');
        }
    } else {
        if (file_exists($xmlFile)) {
            $xml = simplexml_load_file($xmlFile);
        } else {
            exit('Failed to open test.xml.');
        }
        //p        opulate dropdown from xml info!
        $hasSelectedRestaurant = true;
        
        //n        ow we have to set the selected restaurant
        
        
        foreach ($xml as $resto) {
            if ($_POST['drpRestaurants'] == $resto->Name) {
                $selectedRestaurant = $resto;
            }
        }
    }
}




?>
   <head><head>
    <body>
    <form action="" method="POST" name="frmXMLRestaurants" >
        <table>
            <tr>
                <td>Select a restaurant</td>
                <td>
                    <select name='drpRestaurants' onchange="this.form.submit();">
                        <option value="-1">Please select a restaurant...</option>
                        <?php
foreach ($xml as $restaurant) {
    
    
    if ($hasSelectedRestaurant && $_POST["drpRestaurants"] == $restaurant->Name) {
        
        
        echo ("<option value='$restaurant->Name' SELECTED>$restaurant->Name</option>");
        
        
    }
    
    
    else {
        
        
        echo ("<option value='$restaurant->Name'>$restaurant->Name</option>");
        
        
    }
    
    
}



?>
                   </select>
                </td>
            </tr>
            <?php
if ($hasSelectedRestaurant) //only draw this part if 
    {
    
    
    
    
?>
           <tr>
                <td>Address</td>
                <td>
                    <textarea name='txtAddress' rows='3' readonly><?php
    echo ($selectedRestaurant->RestaurantAddress->Address . ", " . $selectedRestaurant->RestaurantAddress->City);
?> </textarea>
                </td>
            </tr>
            <tr>
                <td>Summary</td>
                <td>
                    <textarea row='3' name='txtSummary'><?php
    echo ($selectedRestaurant->Summary);
?>  </textarea>
                </td>
            </tr>
            <tr>
                <td>Rating</td>
                <td>
                    <select name='drpRating'>
                        <?php
    for ($i = 1; $i < 6; $i++) {
        
        if ($selectedRestaurant->Rating == $i) {
            
            echo ("<option value='$i' selected>$i</option>");
            
        }
        
        else {
            
            echo ("<option value='$i'>$i</option>");
            
        }
        
    }
    
?>
                   </select>
                </td>
            </tr>
            <?php
}

?>
       </table>
        <?php
if ($hasSelectedRestaurant) //only draw this part if 
    {
    
?>
       <input type='submit' value="Save" name='submitSave' />
        <?php
}
if ($saveSuccess) {
    echo "\r\n";
    echo "Successfully saved file to: " . $xmlFile;
}
?>
       </form>
    </body>
</html>
