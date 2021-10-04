class CreateKmlFile
{   
    public function __construct() {
        $this->list_placemarks = [];
    }

    function create($config = [])
    {   $kml   = array();

        $kml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $kml[] = '<kml xmlns="http://www.opengis.net/kml/2.2">';//'<kml xmlns="http://earth.google.com/kml/2.1">';
        $kml[] = '<Document>';

        if(isset($config['name'])){
            $kml[] = '<name>'.$config['name'].'</name>';
        }

        if(isset($config['description'])){
            $kml[] = "<description>".$config['description']."</description>";
        }

        $kml[] = join("\n", $this->list_placemarks);
        $kml[] = "\n </Document>";
        $kml[] = '</kml>';

        return join("\n", $kml);
    }

    function placemark($name, $geom, $description = false,  $config = [])
    {   $placemark   = array();

        $placemark[] = "\n <Placemark>";
        $placemark[] = "\t <name>".$name."</name>";

        if($description){
            $placemark[] = "\t <description>".$description."</description>";
        }

        if(isset($config['style'])){
            $placemark[] = "\t <styleUrl>".$config['style']."</styleUrl>";
        }

        $placemark[] = $geom;
        $placemark[] = '</Placemark>';

        $this->list_placemarks[] =  join("\n", $placemark);
    }

    function lineString($coordinates)
    {
        return "
                <LineString>
                    <extrude>1</extrude>
                    <tessellate>1</tessellate>
                    <altitudeMode>absoluto</altitudeMode>
                    <coordinates>\n ".join("\n", $coordinates)."\n </coordinates>
                </LineString>";
    }

    function coordinate($lon, $lat, $config = [])
    {
        $srid = (isset($config['srid']) ? $config['srid'] : 4326);

        return ("\t \t ".$lon . "," . $lat . "," . $srid);
    }
}
