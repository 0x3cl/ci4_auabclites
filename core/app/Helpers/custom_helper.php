<?php

function toggleFlashData($show, $duration) {
    echo '
        <script>
            setTimeout(() => {
                $(".flashdata-message").addClass("active");
            }, '.$show.');
            setTimeout(() => {
                $(".flashdata-message").removeClass("active");
            }, '.$duration.');
        </script>
    ';
}

function readFlashData($flashdata) {
    if (!empty($flashdata)) {
        if (is_array($flashdata['message'])) {
            $message = '';
            foreach ($flashdata['message'] as $msg) {
                $message .= '
                    <div class="d-flex align-items-center gap-2">
                        <i class="bx bx-x"></i>
                        <p class="mb-0">'.$msg.'</p>
                    </div>
                ';
            }
            echo '
            <div class="flashdata-message ' . $flashdata['status'] . '">
                <div class="message-content">
                    <ul>' . $message . '</ul>
                </div>
            </div>
            ';
        } else {
            echo '
            <div class="flashdata-message ' . $flashdata['status'] . '">
                <div class="message-content">' . $flashdata['message'] . '</div>
            </div>
            ';
        }

        if(array_key_exists('scrollTo', $flashdata) && !empty($flashdata['scrollTo'])) {
            scrollToDiv($flashdata['scrollTo']);
        }

    }
    toggleFlashData(100, 5000);
}

function scrollToDiv($div) {
    echo '
        <script>

            setTimeout(() => {
                const scrollToElement = $("#" + "'.$div.'");
                if (scrollToElement.length > 0) {
                    $("html, body").scrollTop(scrollToElement.offset().top - 200);
                }
            });

        </script>
    ';
}

function format_position($id) {
    $positions = [
        1 => 'dean',
        2 => 'adviser',
        3 => 'president',
        4 => 'vice president internal',
        5 => 'vice president external',
        6 => 'secretary',
        7 => 'assistant secretary',
        8 => 'treasurer',
        9 => 'assistant treasurer',
        10 => 'auditor',
        11 => 'assistant auditor',
        12 => 'P.I.O',
        13 => 'editor in chief/photography',
        14 => 'associate editor',
        15 => 'managing editor',
        16 => 'news editor',
        17 => 'literary editor',
        18 => 'layout artist/graphic designer',
        19 => 'lead developer',
        20 => 'developer',
        21 => '1st year representative',
        22 => '2nd year representative',
        23 => '3rd year representative',
        24 => '4th year representative'
    ];

    // Check if the $id exists in the array, and return the corresponding value or an empty string if not found.
    return isset($positions[$id]) ? $positions[$id] : '';
}

function format_field_value($array, $field) {
     if(is_array($array)) {
        return ($array != null) ? $array[$field] : '';
     }
     if(is_object($array)) {
        return ($array != null) ? $array->$field : '';
     }
}

function format_bulletin_category($num) {
    return ($num == 1) ? 'announcements' : (($num == 2) ? 'news' : '');
}

function format_timestamp_to_date($timestamp) {
    $dateTime = new DateTime($timestamp);
    return $dateTime->format('F j, Y');
}

function format_timestamp_to_time($timestamp) {
    $dateTime = new DateTime($timestamp); 
    return $dateTime->format('h:i A');
}

function convertReferrer($url) {
    $matches = array();
    if (preg_match('/https:\/\/l\.([^.]+)\.com\//', $url, $matches)) {
        return strtoupper($matches[1]);
    }
    return false;
}

function repo_icon($name) {
    switch($name) {
        case 'github':
            return '<i class="bx bxl-github"></i>';
            break;
        case 'gdrive':
            return '<i class="bx bxl-google-cloud"></i>';
            break;
        case 'mega':
            return '<i class="bx bxl-bitbucket"></i>';
            break;
        case 'terabox':
            return '<i class="bx bxl-bitbucket-server"></i>';
            break;
        case 'dropbox':
            return '<i class="bx bxl-gitlab-server"></i>';
            break;
    }
}

function optimizeImageUpload($path, $file, $filename) {
    $image = \Config\Services::image();
    $image->withFile($file)
    ->resize(800, 800, true, 'height')
    ->withResource()
    ->save($path . $filename, 50);
    return true;
}

function removeImage($path) {
    if(file_exists($path) && unlink($path)) {
        return true;
    }
    return false;
}