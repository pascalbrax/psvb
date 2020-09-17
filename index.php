<html>
<head>

    <!-- 

        YOU NEED TO DOWNLOAD VIDEOS WITH 'youtube-dl --write-info-json --write-thumbnail' PARAMETERS!

    -->

    <!-- jQuery and Bootstrap CDNs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <style type="text/css">
        body { background: black !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
        h1 { color: white; 
            margin-left: 10px !important; }
        h5 { color: gray; }
        h6 { color: gray;
            margin-left: 10px !important; } }
        a { color: white; }

    </style>
    <title>Pascal simple youtube-dl viewer and browser</title>
</head>
<body>

<h1>Pascal Simple <i>youtube-dl</i> video browser</h1>
<hr>

<div class="container-fluid bg-dark text-white ">
<div class="row ">

<?php

// scan for files and creates divs
foreach (glob("*.{mp4,mkv,webm}",GLOB_BRACE) as $filename) {

    $basename =  pathinfo($filename, PATHINFO_FILENAME);

    $jsonname = $basename.".info.json";
    $json = json_decode(file_get_contents($jsonname));

    $title = $json->title;
    $uploader = $json->uploader;
    $uploader_url = $json->uploader_url;
    $upload_date = $json->upload_date;
    $human_date = substr_replace($upload_date, "-", 4, 0);
    $human_date = substr_replace($human_date, "-", 7, 0);
    $webpage_url = $json->webpage_url;
    $view_count = $json->view_count;
    $playlist = $json->playlist_title;
    $thumbnail = $json->thumbnail;
    $thumbnail_file = $basename.".".pathinfo($thumbnail, PATHINFO_EXTENSION);



    echo "<div class=\"col-lg-3\">";

    echo "<h3>$title</h3>";
    if ($playlist) {
        echo "<h5>$playlist</h5>";
    }
    echo "<a href=\"$filename\"><img src=\"$thumbnail_file\" class=\"img-thumbnail\" width=50%></a>";

    echo "<h4>By <a href=\"$uploader_url\">$uploader</a></h4>";
    echo "<h5>$view_count views</h5>";
    echo "<h5>Date: $human_date</h5>";
    
    echo "<h6>$filename size " . human_filesize(filesize($filename)) . "</h6>\n";

    echo "</div>"; 
}

echo "</div></div>";

function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    } 

?>

<hr>
<h6><a href="https://github.com/pascalbrax/psvb">https://github.com/pascalbrax/psvb</a></h6>

</body>
</html>
