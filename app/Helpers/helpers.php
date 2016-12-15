<?php 
use Carbon\Carbon;

function analys_name($name)
{
    $names = explode(' ', $name);

    foreach ($names as $index => $word) {
        if ($word == "") {
            unset($names[$index]);
        }
    }
    $names = array_values($names);

    $length = count($names);

    if ($length == 1) {
        return [
            'last_name'   => '',
            'middle_name' => '',
            'first_name'  => $names[0],
        ];
    }
    if ($length == 2) {
        return [
            'last_name'   => $names[0],
            'middle_name' => '',
            'first_name'  => $names[1],
        ];
    } else {
        $middle_name = '';

        for ($i = 1; $i <= $length - 3; $i++) {
            $middle_name .= $names[$i] . ' ';
        }
        $middle_name .= $names[$length - 2];

        return [
            'last_name'   => $names[0],
            'middle_name' => $middle_name,
            'first_name'  => $names[$length - 1],
        ];
    }
}

function getBytesFromHexString ($hexdata)
{
    for ($count = 0; $count < strlen($hexdata); $count += 2)
    {
        $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));
    }

    return implode($bytes);
}

function getImageMimeType ($imagedata)
{
    $imagemimetypes = array(
        "jpeg" => "FFD8",
        "png"  => "89504E470D0A1A0A",
        "gif"  => "474946",
        "bmp"  => "424D",
        "tiff" => "4949",
        "tiff" => "4D4D"
    );

    foreach ($imagemimetypes as $mime => $hexbytes)
    {
        $bytes = getBytesFromHexString($hexbytes);
        if (substr($imagedata, 0, strlen($bytes)) == $bytes)
        {
            return $mime;
        }
    }

    return null;
}

function flash($title = null, $message = null)
{
    $flash = app('App\Http\Flash');

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->info($title, $message);

}

function html_alert($type,$text){
    return '<div class="alert alert-'.type.'" align="center">'.$text.'</div>';
}

function response_success($message,$data){
    return response()->json([
                'code' => 200,
                'message' => $message,
                'data' => $data
            ]);
}

function response_error($code,$message,$data){
    return response()->json([
                'code' => $code,
                'message' => $message,
                'params' => $data
            ]);
}