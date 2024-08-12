# Apex Hosting Hiring Challenge

## Abstract
This is a collection of scripts written in PHP 8.3 for managing a whitelist.json file. One script allows a user to add a username and ID to the JSON file with only the username. The script will reach out to the Mojang API to retrieve that username's ID. If that username exists, the ID is returned and both the username and ID are added to the JSON file. The other script allows a user to delete a username from the JSON file by either their username or ID. 

## Usage
Clone the repository on your local maching. 
Open a terminal and navigate to the directory where you've cloned the repository. There are no dependencies needed. 

### Add User
To add a user to whitelist.json simply run the following command:

`php addUser.php`

- You will be prompted to enter an username. 
- Press enter after doing so. 
- Your user will be added to whitelist.json. 

### Delete User
To delete a user from whitelist.json simply run the following command:

`php deleteUser.php`

- You will be prompted to enter an username or ID. 
- Press enter after doing so. 
- Your user will be removed from whitelist.json 

## Error Log
Should an error occur, the user will be alerted on the command line. The error will also be logged in errorLog.txt which will be created automatically upon the first error. 
