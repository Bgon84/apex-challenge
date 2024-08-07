<?php

    function logError(string $message) : void
    {
        $text = date("Y-m-d H:i:s") . " ERROR: " . $message  . PHP_EOL;

        file_put_contents("errorLog.txt", $text, FILE_APPEND);
    }

    function findUserIdByName(string $username) : array
    {
        $apiBase = "https://api.mojang.com/users/profiles/minecraft/";
        $url = $apiBase . $username;

        try{
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                ],
            ]);
    
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
    
            if(array_key_exists("id", $result)){
                return ["found", $result["id"]];
            } else {
                return ["error", $result["errorMessage"]];
            }
        }catch(Throwable $th){
            logError($th->getMessage());
            return ["error", "An Error Occurred. The Mojang API cannot be reached at this time." . PHP_EOL];
        }
    }

    function nameExistsOnList(string $username) : bool
    {
        $contents = file_get_contents("whitelist.json");
        $contentsArray = json_decode($contents);

        if(!is_null($contentsArray)){
            foreach($contentsArray as $user){
                if(strtoupper($user->name) == $username){
                    return true;
                }
            }
        }
        return false;
    }