<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
        $chartData=file_get_contents('assets/wanita.json');
        $chartData=json_decode($chartData);
        $res=array();
        foreach($chartData as $row)
        {
            $dat=[$row->tahun,(double)$row->val];
            array_push($res,$dat);
        }
        // echo json_encode($res);
        $data['PieChartTitle']='Jumlah Penduduk Wanita Tidak/Belum Sekolah di Kabupaten Purworejo';
        $data['PieChartData']=json_encode($res);
        $this->load->view('grafik', $data);
	}

    function ayam()
    {
        //people data
        $source=file_get_contents('assets/ayam.json');
        $source=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $source), true );  
        $result=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['daerah_habitat']]))
            {
                $result[$row['daerah_habitat']]=array($row['jenis_ayam']);
            }else{
                array_push($result[$row['daerah_habitat']], $row['jenis_ayam']);
            }
        }
        $keys=array_keys($result);
        $people=array();
        foreach ($keys as $row)
        {
            $people[]=[$row, count($result[$row])];
        }
        $data['PieChartData']=json_encode($people);
        $data['PieChartTitle']='Data Habitat ayam';

        //line chart
        $line=[array('JENIS AYAM', 'populasi')];
        foreach($source as $row)
        {
            // $dat=array($row['jenis_ayam'], (double)$row['populasi']);
            // array_push($line, $dat);
            $year=($row['tahun']);
            if($year=='2017')
            {
                $dat=array($row['jenis_ayam'], (double)$row['populasi']);
                array_push($line, $dat);
            }
        }
        $data['LineChartData']=json_encode($line);
        $data['LineChartTitle']='Data Populasi Ayam Tahun 2018';

        //bar chart
        $bar=[array('JENIS AYAM', 'POPULASI 2017', 'POPULASI 2018')];
        foreach($source as $row)
        {
            $year=($row['tahun']);
            $ayam=($row['jenis_ayam']);
            if($year=='2017')
            {
                if(!isset($totalData['2017'][$ayam]))
                {
                    $totalData['2017'][$ayam]=$row['populasi'];
                }else{
                    array_push($totalData['2017'][$ayam],$row['populasi']);
                }
            }
            if($year=='2018')
            {
                if(!isset($totalData['2018'][$ayam]))
                {
                    $totalData['2018'][$ayam]=$row['populasi'];
                }else{
                    array_push($totalData['2018'][$ayam],$row['populasi']);
                }
            }
        }
        $ayam=array_keys($totalData['2017']);
        foreach(array_keys($totalData['2017']) as $row)
        {
            $dat=[$row, ($totalData['2017'][$row]), ($totalData['2018'][$row])];
            array_push($bar, $dat);
        }
        $data['BarChartData']=json_encode($bar);
        $data['BarChartTitle']='Perbandingan Populasi Ayam Tahun 2017 dan 2018';
        $this->load->view('grafik', $data);
        // echo json_encode($bar);
    }
}