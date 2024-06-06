<?php
use Dompdf\Dompdf;

class Dompdf_lib {
    public function __construct() {
        require_once APPPATH.'../vendor/autoload.php';
    }

    public function create_pdf($html, $filename = '', $stream = true) {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        if ($stream) {
            $dompdf->stream($filename, array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}
?>
