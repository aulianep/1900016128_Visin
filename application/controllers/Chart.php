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

    function hewan()
    {
        //people data
        $source=file_get_contents('assets/hewan.json');
        $source=json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $source), true );  
        $result=array();
        foreach($source as $row)
        {
            if(!isset($result[$row['tempat_habitat']]))
            {
                $result[$row['tempat_habitat']]=array($row['jenis_hewan']);
            }else{
                array_push($result[$row['tempat_habitat']], $row['jenis_hewan']);
            }
        }
        $keys=array_keys($result);
        $people=array();
        foreach ($keys as $row)
        {
            $people[]=[$row, count($result[$row])];
        }
        $data['PieChartData']=json_encode($people);
        $data['PieChartTitle']='Data Habitat Hewan';

        //line chart
        $line=[array('JENIS HEWAN', 'populasi')];
        foreach($source as $row)
        {
            // $dat=array($row['jenis_hewan'], (double)$row['populasi']);
            // array_push($line, $dat);
            $year=($row['tahun']);
            if($year=='2018')
            {
                $dat=array($row['jenis_hewan'], (double)$row['populasi']);
                array_push($line, $dat);
            }
        }
        $data['LineChartData']=json_encode($line);
        $data['LineChartTitle']='Data Populasi Hewan Tahun 2019';

        //bar chart
        $bar=[array('JENIS HEWAN', 'POPULASI 2018', 'POPULASI 2019')];
        foreach($source as $row)
        {
            $year=($row['tahun']);
            $hewan=($row['jenis_hewan']);
            if($year=='2018')
            {
                if(!isset($totalData['2018'][$hewan]))
                {
                    $totalData['2018'][$hewan]=$row['populasi'];
                }else{
                    array_push($totalData['2018'][$hewan],$row['populasi']);
                }
            }
            if($year=='2019')
            {
                if(!isset($totalData['2019'][$hewan]))
                {
                    $totalData['2019'][$hewan]=$row['populasi'];
                }else{
                    array_push($totalData['2019'][$hewan],$row['populasi']);
                }
            }
        }
        $hewan=array_keys($totalData['2018']);
        foreach(array_keys($totalData['2018']) as $row)
        {
            $dat=[$row, ($totalData['2018'][$row]), ($totalData['2019'][$row])];
            array_push($bar, $dat);
        }
        $data['BarChartData']=json_encode($bar);
        $data['BarChartTitle']='Perbandingan Populasi Hewan Tahun 2018 dan 2019';
        $this->load->view('grafik', $data);
        // echo json_encode($bar);
    }
}