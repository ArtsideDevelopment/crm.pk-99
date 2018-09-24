<?php
/**  
* We connect a configuration file  
* Подключаем конфигурационный файл  
*/  
    define('AS_KEY', true);
    header("Content-Type: application/json");
/**   
* Installation of a key of access to files   
* Установка ключа доступа к файлам   
*/ 
    define('AS_KEY', true);
/**  
* We connect a configuration file  
* Подключаем конфигурационный файл  
*/  
    include_once './config.php';
/**   
* We connect exeptions file     
* Подключаем файл исключений
*/      
    include_once AS_ROOT .'libs/exceptions.php';
/**  
* We connect a file of sequriy functions  
* Подключаем файл функции безопасности
*/      
    include_once AS_ROOT .'libs/security.php'; 
    echo json_encode(array(
    array(
        "name"          => "Ducks2",
        "img"           => "ducks",
        "city"          => "Saint-Petersburg",
        "id"            => "ANA",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Thrashers",
        "img"           => "thrashers",
        "city"          => "Atlanta",
        "id"            => "ATL",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    ),
    array(
        "name"          => "Bruins",
        "img"           => "bruins",
        "city"          => "Boston",
        "id"            => "BOS",
        "conference"    => "Eastern",
        "division"      => "Northeast"
    ),
    array(
        "name"          => "Sabres",
        "img"           => "sabres",
        "city"          => "Buffalo",
        "id"            => "BUF",
        "conference"    => "Eastern",
        "division"      => "Northeast"
    ),
    array(
        "name"          => "Flames",
        "img"           => "flames",
        "city"          => "Calgary",
        "id"            => "CGY",
        "conference"    => "Western",
        "division"      => "Northwest"
    ),
    array(
        "name"          => "Hurricanes",
        "img"           => "hurricanes",
        "city"          => "Carolina",
        "id"            => "CAR",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    ),
    array(
        "name"          => "Blackhawks",
        "img"           => "blackhawks",
        "city"          => "Chicago",
        "id"            => "CHI",
        "conference"    => "Western",
        "division"      => "Central"
    ),
    array(
        "name"          => "Avalanche",
        "img"           => "avalanche",
        "city"          => "Colorado",
        "id"            => "COL",
        "conference"    => "Western",
        "division"      => "Northwest"
    ),
    array(
        "name"          => "Bluejackets",
        "img"           => "bluejackets",
        "city"          => "Columbus",
        "id"            => "CBJ",
        "conference"    => "Western",
        "division"      => "Central"
    ),
    array(
        "name"          => "Stars",
        "img"           => "stars",
        "city"          => "Dallas",
        "id"            => "DAL",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Red Wings",
        "img"           => "redwings",
        "city"          => "Detroit",
        "id"            => "DET",
        "conference"    => "Western",
        "division"      => "Central"
    ),
    array(
        "name"          => "Oilers",
        "img"           => "oilers",
        "city"          => "Edmonton",
        "id"            => "EDM",
        "conference"    => "Western",
        "division"      => "Northwest"
    ),
    array(
        "name"          => "Panthers",
        "img"           => "panthers",
        "city"          => "Florida",
        "id"            => "FLA",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    ),
    array(
        "name"          => "Kings",
        "img"           => "kings",
        "city"          => "Los Angeles",
        "id"            => "LAK",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Wild",
        "img"           => "wild",
        "city"          => "Minnesota",
        "id"            => "MIN",
        "conference"    => "Western",
        "division"      => "Northwest"
    ),
    array(
        "name"          => "Canadiens",
        "img"           => "canadiens",
        "city"          => "Montreal",
        "id"            => "MTL",
        "conference"    => "Eastern",
        "division"      => "Northeast"
    ),
    array(
        "name"          => "Predators",
        "img"           => "predators",
        "city"          => "Nashville",
        "id"            => "NSH",
        "conference"    => "Western",
        "division"      => "Central"
    ),
    array(
        "name"          => "Devils",
        "img"           => "devils",
        "city"          => "New Jersey",
        "id"            => "NJD",
        "conference"    => "Eastern",
        "division"      => "Atlantic"
    ),
    array(
        "name"          => "Islanders",
        "img"           => "islanders",
        "city"          => "New York",
        "id"            => "NYI",
        "conference"    => "Eastern",
        "division"      => "Atlantic"
    ),
    array(
        "name"          => "Rangers",
        "img"           => "rangers",
        "city"          => "New York",
        "id"            => "NYR",
        "conference"    => "Eastern",
        "division"      => "Atlantic"
    ),
    array(
        "name"          => "Senators",
        "img"           => "senators",
        "city"          => "Ottawa",
        "id"            => "OTT",
        "conference"    => "Eastern",
        "division"      => "Northeast"
    ),
    array(
        "name"          => "Flyers",
        "img"           => "flyers",
        "city"          => "Philadelphia",
        "id"            => "PHI",
        "conference"    => "Eastern",
        "division"      => "Atlantic"
    ),
    array(
        "name"          => "Coyotes",
        "img"           => "coyotes",
        "city"          => "Phoenix",
        "id"            => "PHX",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Penguins",
        "img"           => "penguins",
        "city"          => "Pittsburgh",
        "id"            => "PIT",
        "conference"    => "Eastern",
        "division"      => "Atlantic"
    ),
    array(
        "name"          => "Sharks",
        "img"           => "sharks",
        "city"          => "San Jose",
        "id"            => "SJS",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Blues",
        "img"           => "blues",
        "city"          => "St. Louis",
        "id"            => "STL",
        "conference"    => "Western",
        "division"      => "Central"
    ),
    array(
        "name"          => "Lightning",
        "img"           => "lightning",
        "city"          => "Tampa Bay",
        "id"            => "TBL",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    ),
    array(
        "name"          => "Maple Leafs",
        "img"           => "mapleleafs",
        "city"          => "Toronto",
        "id"            => "TOR",
        "conference"    => "Eastern",
        "division"      => "Northeast"
    ),
    array(
        "name"          => "Canucks",
        "img"           => "canucks",
        "city"          => "Vancouver",
        "id"            => "VAN",
        "conference"    => "Western",
        "division"      => "Northwest"
    ),
    array(
        "name"          => "Capitals",
        "img"           => "capitals",
        "city"          => "Washington",
        "id"            => "WSH",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    ),
    array(
        "name"          => "Jets",
        "img"           => "jets",
        "city"          => "Winnipeg",
        "id"            => "WPG",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    )
));
    
    //$order_id=isset($_GET['order_id']) ? $_GET['order_id'] : 0;
    //$document=isset($_GET['document']) ? $_GET['document'] : "";
    