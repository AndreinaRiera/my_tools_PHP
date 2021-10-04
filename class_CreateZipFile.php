class CreateZipFile
{
    public function __construct() {
        $this->filesRaw = [];
    }

    function add($name, $file)
    {
        if($file){
            $this->filesRaw[] = [$name, $file];
        }
    }

    function create($filename)
    {
        $zip = new ZipArchive();

        if ($zip->open($filename, ziparchive::CREATE) !== TRUE) {
            exit("cannot open <$filename>\n");
        }

        $filesRaw = $this->filesRaw;
        for ($i=0; $i < count($filesRaw); $i++) { 
            $zip->addFromString($filesRaw[$i][0], $filesRaw[$i][1]); // add new raw file
        }

        // close and save archive
        $zip->close();

        // download file
        if (file_exists($filename)) {
            setHeader([
                'file'=> $filename,
                'type'=> 'zip'
            ]);

            // download zip
            readfile($filename);
            
            // delete after download
            unlink($filename);
        }
    }
}
