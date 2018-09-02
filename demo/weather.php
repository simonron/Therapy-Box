<?php 

function GetWeather($state,$country,$langauge,$waetherIcons){
// auf der Basis von http://www.web-spirit.de/webdesign-tutorial/9/Wetter-auf-eigener-Website-mit-Google-Weather-API
        $api = simplexml_load_string(utf8_encode(file_get_contents("http://www.google.com/ig/api?weather=".$state."-".$country."&hl=".$langauge)));
        // $trans = array("Ã¤" => "ä", "Ã„" => "Ä", "Ã¼" => "ü", "Ãœ" => "Ü", "Ã¶" => "ö", "Ã–" => "Ö", "ÃŸ" => "ß");
        $trans = array("ü" => "ü", "ö" => "ö", "ä" => "ä", "ß" => "ß");
        $weather = array();
        $i = 1;
        foreach($api->weather->forecast_conditions as $GoogleWeather){
                $waetherIcons = $GoogleIcons = "/ig/images/weather/";
                $weather[$i]['zustand']                         = strtr(strtolower($GoogleWeather->condition->attributes()->data), $trans);
                $weather[$i]['tiefsttemperatur']        = $GoogleWeather->low->attributes()->data;
                $weather[$i]['hoechsttemperatur']       = $GoogleWeather->high->attributes()->data;
                $weather[$i]['icon']                            = str_replace($GoogleIcons, $waetherIcons, $GoogleWeather->icon->attributes()->data);
                $i++;
        }
        return $weather;
}

GetWeather('ca', 'usa', 'en', 'true');