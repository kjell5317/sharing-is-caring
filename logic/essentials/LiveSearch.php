<?php
include_once "Database.php";
include_once "../SQLCardDAO.php";

//get the q parameter from URL
$q = $_GET["q"];
$hint = "";

//lookup all links from the xml file if length of q>0
if (strlen($q) > 0) {
    $db = Database::getInstance();
    $conn = $db->getDatabase();
    $cardmanager = new SQLCardDAO($conn);
    $results = $cardmanager->queryCards(strtolower($q));
    $results = array_slice($results, 0, 5);

    foreach ($results as $result) {
        $result = unserialize($result);

        //find a link matching the search text
        if ($hint == "") {
            $hint = "<a class='hover' href='eintrag.php?id=" .
                $result->id .
                "'>" .
                $result->title . "</a>";
        } else {
            $hint = $hint . "<a class='hover' href='eintrag.php?id=" .
                $result->id .
                "'>" .
                $result->title . "</a>";
        }
    }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint == "") {
    $response = "Kein Vorschlag";
} else {
    $response = $hint;
}

//output the response
echo $response;
?>