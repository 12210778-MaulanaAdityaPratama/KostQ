<?php
class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Laporan_model');
    }

    public function index() {
        $month = $this->input->post('month') ? $this->input->post('month') : date('m');
        $year = $this->input->post('year') ? $this->input->post('year') : date('Y');
        $show_all = $this->input->post('show_all') ? true : false;
    
        if ($show_all) {
            $data['title'] = 'Laporan Transaksi - Semua Transaksi';
            $data['laporan_unpaid'] = $this->Laporan_model->get_all_unpaid_transactions();
            $data['laporan_paid'] = $this->Laporan_model->get_all_paid_transactions();
            $data['totals_unpaid'] = $this->Laporan_model->get_all_unpaid_totals(); // Total transaksi belum lunas
            $data['totals_paid'] = $this->Laporan_model->get_all_paid_totals(); // Total transaksi lunas
        } else {
            $data['title'] = 'Laporan Transaksi - ' . date('F', mktime(0, 0, 0, $month, 10)) . ' ' . $year;
            $data['laporan_unpaid'] = $this->Laporan_model->get_unpaid_transactions_by_month($month, $year);
            $data['laporan_paid'] = $this->Laporan_model->get_paid_transactions_by_month($month, $year);
            $data['totals_unpaid'] = $this->Laporan_model->get_unpaid_totals_by_month($month, $year);
            $data['totals_paid'] = $this->Laporan_model->get_paid_totals_by_month($month, $year);
        }
    
        $data['selected_month'] = $month;
        $data['selected_year'] = $year;
        $data['show_all'] = $show_all;
    
        $this->load->view('back/laporan/index', $data);
    }
    
    public function generate_pdf() {
        $month = $this->input->post('month') ? $this->input->post('month') : date('m');
        $year = $this->input->post('year') ? $this->input->post('year') : date('Y');
        $show_all = $this->input->post('show_all') ? true : false;
    
        if ($show_all) {
            $data['title'] = 'Laporan Transaksi - Semua Transaksi';
            $data['laporan_unpaid'] = $this->Laporan_model->get_all_unpaid_transactions();
            $data['laporan_paid'] = $this->Laporan_model->get_all_paid_transactions();
            $data['totals_unpaid'] = $this->Laporan_model->get_all_unpaid_totals(); // Total transaksi belum lunas
            $data['totals_paid'] = $this->Laporan_model->get_all_paid_totals(); // Total transaksi lunas
        } else {
            $data['title'] = 'Laporan Transaksi - ' . date('F', mktime(0, 0, 0, $month, 10)) . ' ' . $year;
            $data['laporan_unpaid'] = $this->Laporan_model->get_unpaid_transactions_by_month($month, $year);
            $data['laporan_paid'] = $this->Laporan_model->get_paid_transactions_by_month($month, $year);
            $data['totals_unpaid'] = $this->Laporan_model->get_unpaid_totals_by_month($month, $year);
            $data['totals_paid'] = $this->Laporan_model->get_paid_totals_by_month($month, $year);
        }
    
        $html = $this->load->view('back/laporan/pdf_template', $data, true);
    
        $this->load->library('Dompdf_lib');
        $this->dompdf_lib->create_pdf($html, 'Laporan_Transaksi.pdf');
    }
    
    
}


?>
