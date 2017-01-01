<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        // $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_mk_individual?$skiptoken=50';
        // $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_t_mk_status';
        $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_mk_expense(1)';
        $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_faction_knesset';
        $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_t_faction';
        $url = 'http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_mk_individual(1)';

        $file = file_get_contents($url);
        $sxe = new \SimpleXMLElement($file);
        // dd($sxe);

        // foreach ($sxe->entry as $entry) {
        //     foreach ($entry->content as $item) {
            foreach ($sxe->content as $item) {
                $element = $item->children('m', true);
                $properties = $element->properties;
                $elements = $properties->children('d', true);

                foreach ($elements as $k => $e) {
                    $mypes = $e->children('m', true);
                    echo '<strong>'.$k.'</strong><br>'.$elements->$k.'<br>';
                    var_dump($mypes);
                    echo '<hr>';
                }
            }
        // }

        dd($sxe);

        // $headers[] = 'OData-Version: 4.0';
        // $headers[] = 'OData-MaxVersion: 4.0';
        $headers['CURLOPT_HEADER'] = true;
        $curl_opts[CURLOPT_HTTPHEADER] = $headers;

        $curl = curl_init($url);
        curl_setopt_array($curl, $curl_opts);
        $response = curl_exec($curl);
        dd('r');
        $curl_info = curl_getinfo($curl);

        curl_close($curl);

        // Retrieve the info
        $header_size = $curl_info['header_size'];
        $headers = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        dd($response);

    	return $curl_info;
    }
}
