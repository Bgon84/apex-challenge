<?php   
    require_once("helperfunctions.php");

    $jsonFile = "whitelist.json";

    if(!file_exists($jsonFile)){
        logError($jsonFile . " was not found.");
        echo "Cannot find " . $jsonFile . PHP_EOL;
    }

    $identifier = readline("Enter Username or ID to delete from Whitelist: ");

    if($identifier == ""){
        die("Username cannot be blank." . PHP_EOL);
    }

    $identifier = strtoupper(trim(str_replace(" ", "", $identifier)));

    try{
        $list = file_get_contents($jsonFile);
        $listArray = json_decode($list);
        $userRemoved = false;

        if(is_null($listArray)){
            die("Unable to read " . $jsonFile ." . Please ensure the file has not been corrupted." . PHP_EOL);
        }
    
        for($i=0; $i<count($listArray); $i++)
        {
            if(strtoupper($listArray[$i]->name) == $identifier || strtoupper($listArray[$i]->id) == strtoupper($identifier)){
                unset($listArray[$i]);
                $userRemoved = true;
            }
        }
        
        if($userRemoved){
            $newList = json_encode(array_values($listArray), JSON_PRETTY_PRINT);
            file_put_contents($jsonFile, $newList);
            
            $resultMsg = "Deleted Successfully!";
        } else {
            $resultMsg = "Not Found";
        } 

        echo "User " . $identifier . " Was ". $resultMsg . PHP_EOL;
    
    } catch(Throwable $th) {
        logError($th->getMessage());
        echo "An error has occurred. Please contact your administrator." . PHP_EOL;
    }