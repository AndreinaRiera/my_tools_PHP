
function setHeader($config)
{
    $type = $config['type'];

    switch ($type) {
        case 'zip':
            header('Content-Type: application/zip');
            break;
        case 'kml':
            header('Content-type: application/vnd.google-earth.kml+xml');
            break;
        case 'csv':
            header("Content-type: text/csv; charset=UTF-8");
            break;
    }

    $filename = 'archivo.'.$type;

    if(isset($config['file'])){
        $filename = $config['file'];
        header('Content-Length: ' . filesize($config['file']));
    }

    if(isset($config['filename'])){
        $filename = $config['filename'];
    }

    header('Content-Encoding: UTF-8');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Content-Description: File Transfer');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: no-cache');
}
