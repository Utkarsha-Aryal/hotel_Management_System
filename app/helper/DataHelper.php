<?php
function filterData($post)
{
    foreach ($post as $key => $data) {
        $val = [];

        // Check if the data is an image (either URL, base64 string, or an uploaded file)
        if (is_string($data) && (preg_match('/\.(jpeg|jpg|png|gif|bmp|svg)$/i', $data) || strpos($data, 'data:image/') === 0)) {
            // If it's an image URL or base64 image, skip filtering
            $val = $data;
        } elseif ($data instanceof \Illuminate\Http\UploadedFile) {
            // If the data is an uploaded file (file input), process it
            $val = $data->store('user-images');  // Store the file, adjust path as necessary
        } else {
            // Otherwise, sanitize the data
            if (!empty($data)) {
                if (is_array($data)) {
                    foreach ($data as $rkey => $rval) {
                        $var = stripslashes($rval);
                        $var = strip_tags($var);
                        $var = htmlspecialchars($var);
                        $var = html_entity_decode(html_entity_decode($var));
                        $val[$rkey] = $var;
                    }
                } else {
                    $val = trim($data);
                    $val = stripslashes($val);
                    $val = strip_tags($val);
                    $val = htmlspecialchars($val);
                    $val = html_entity_decode(html_entity_decode($val));
                }
            } else {
                $val = null;
            }
        }

        // Set the sanitized value back to the post data
        $post[$key] = $val;
    }

    return $post;
}


//  function filterData($post)
//     {
//         foreach ($post as $key => $data) {
//             $val = [];
//             if (!empty($data)) {
//                 if (is_array($data)) {
//                     foreach ($data as $rkey => $rval) {
//                         $var = stripslashes($rval);
//                         $var = strip_tags($var);
//                         $var = htmlspecialchars($var);
//                         $var = html_entity_decode(html_entity_decode($var));
//                         $val[$rkey] = $var;
//                     }
//                 } else {
//                     $val = trim($data);
//                     $val = stripslashes($val);
//                     $val = strip_tags($val);
//                     $val = htmlspecialchars($val);
//                     $val = html_entity_decode(html_entity_decode($val));
//                 }
//             } else {
//                 $val = null;
//             }
//             $post[$key] = $val;
//         }
//         return $post;
//     }

