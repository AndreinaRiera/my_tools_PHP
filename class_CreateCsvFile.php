class CreateCsvFile
{
    public function __construct() {
        $this->list_csv = [];
    }

    function add($data = [])
    {
        $this->list_csv[] = $data;
    }

    function create($config = [])
    {
        $fp        = fopen('php://temp/maxmemory:1048576', 'w');
        if (false === $fp) {
            die('Failed to create temporary file');
        }

        $list_csv = $this->list_csv;

        echo "\xEF\xBB\xBF";
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        foreach ($list_csv as $line) {
            // though CSV stands for "comma separated value"
            // in many countries (including France) separator is ";"
            fputcsv($fp, $line);
        }

        rewind($fp);
        return stream_get_contents($fp);
        fclose($fp);
    }
}
