<?php

namespace App\Console\Commands;

use App\Map;
use Illuminate\Console\Command;

class Sync extends Command
{
    protected $_provinces = [];
    protected $_districts = [];
    protected $_communes = [];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->_init();
        $this->_sync();
    }

    protected function _init()
    {
        $provinces = json_decode(file_get_contents(storage_path('provinces.json')), 1);
        $districts = json_decode(file_get_contents(storage_path('districts.json')), 1);
        $communes = json_decode(file_get_contents(storage_path('communes.json')), 1);

        foreach ($provinces as $item) {
            $this->_provinces[array_get($item, 'id')] = array_get($item, 'name');
        }
        foreach ($districts as $item) {
            $this->_districts[array_get($item, 'id')] = array_get($item, 'name');
        }
        foreach ($communes as $item) {
            $this->_communes[array_get($item, 'id')] = array_get($item, 'name');
        }
    }

    protected function _getLocation($item)
    {
        $province = array_get($this->_provinces, array_get($item, 'tinh'));
        $district = array_get($this->_districts, array_get($item, 'huyen'));
        $commune = array_get($this->_communes, array_get($item, 'xa'));
        return $commune . ' , ' . $district . ', ' . $province;
    }

    protected function _sync()
    {
        $file = "https://cuuhomientrung.info/api/app/hodan/?format=json";
        $data = file_get_contents($file);
        $data = json_decode($data, 1);
        foreach ($data as $key => $item) {
            $location = $this->_getLocation($item);
            if (empty($location)) {
                continue;
            }
            $title = array_get($item, 'name') . ' - ' . array_get($item, 'phone');
            if (Map::where('title', $title)->count()) {
                continue;
            }
            $latlng = $this->_detectLatLng($location);
            $entity = [
                'title' => $title,
                'description' => array_get($item, 'location') . "\r\n" . array_get($item, 'note'),
                'type' => $this->_convertStatus(array_get($item, 'status')),
                'lat' => array_get($latlng, 'lat'),
                'lng' => array_get($latlng, 'lng'),
            ];
            Map::create($entity);
        }
        return response()->json(['ok']);
    }

    protected function _convertStatus($status)
    {

        //  <option value="0">Chưa xác minh</option>
//
//  <option value="1">Cần ứng cứu gấp</option>
//
//  <option value="2" selected="">Không gọi được</option>
//
//  <option value="3">Đã được cứu</option>
//
//  <option value="4">Gặp nạn</option>
        switch (1) {
            case $status == 0:
                return 0; // Chưa rõ
            case $status == 1:
                return 5; // Cực kỳ nguy cấp
            case $status == 2:
                return 2; //  Đang tìm kiếm
            case $status == 3:
                return 1; // Đã cứu trợ
            case $status == 4:
                return 4; // Nguy cấp
        }
        return 0;
    }

    protected function _detectLatLng($address)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/geocode/json?key=' . env('GOOGLE_GEO_API_KEY') . '&address=' . rawurlencode($address));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $json = curl_exec($curl);
        $json = json_decode($json, 1);
        $lat = (array_get($json, 'results.0.geometry.location.lat'));
        $lng = (array_get($json, 'results.0.geometry.location.lng'));
        curl_close($curl);
        return [
            'lat' => $lat,
            'lng' => $lng,
        ];
    }
}
