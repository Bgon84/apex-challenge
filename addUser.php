<?php  
    require_once("helperfunctions.php");

    $jsonFile = "whitelist.json";

    if(!file_exists($jsonFile)){
        logError($jsonFile . " was not found.");
        echo "Cannot find " . $jsonFile . PHP_EOL;
    }

    $name = readline("Enter Username to add to Whitelist: ");
    
    if($name == ""){
        die("Username cannot be blank." . PHP_EOL);
    }

    $name = strtoupper(trim(str_replace(" ", "", $name)));
    
    if(nameExistsOnList($name)){
        die("That username is already on the Whitelist." . PHP_EOL);
    }

    $uuid = findUserIdByName($name);

    if($uuid[0] == "error"){
        die($uuid[1] . PHP_EOL);
    }

    $newUser = ["id" => $uuid[1], "name" => $name];

    try{
        $list = file_get_contents($jsonFile);
        $listArray = json_decode($list);

        if(is_null($listArray)){
            die("Unable to read" . $jsonFile . ". Please ensure the file has not been corrupted." . PHP_EOL);
        }
    
        array_push($listArray, $newUser);
        $newList = json_encode(array_values($listArray), JSON_PRETTY_PRINT);
        file_put_contents($jsonFile, $newList);
        
        echo "User " . $name . " Was Added Successfully!" . PHP_EOL;
    } catch(Throwable $th) {
        logError($th->getMessage());
        echo "An error has occurred. Please contact your administrator." . PHP_EOL;
    }
   