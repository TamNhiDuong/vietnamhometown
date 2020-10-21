<?php

namespace App\Console\Commands;

use App\Map;
use App\Province;
use Illuminate\Console\Command;

class Sync extends Command
{
    protected $_provinces = [];
    protected $_districts = [];
    protected $_communes = [];

    protected $_needHelpProvinces = [
        1, // thua thien hue
        2, // quang tri
        4, // ha tinh
        8// quang binh
    ];

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
        try {
            $this->_init();
            $this->_sync();
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }

    }

    protected function _getProvinces()
    {
        return Province::whereIn('province_id', $this->_needHelpProvinces)->with('districts', 'districts.communes')->get();
    }

    protected function _init()
    {
        $this->_provinces = $this->_getProvinces();
        foreach ($this->_provinces as $province) {
            foreach ($province->districts as $district) {
                foreach ($district->communes as $commune) {
                    $this->_communes[$commune->commune_id] = [
                        'lat' => $commune->lat,
                        'lng' => $commune->lng,
                    ];
                }
            }
        }
    }

    protected function _getLocation($item)
    {
        $communeId = (int)array_get($item, 'xa');
        $latlng = (array)array_get($this->_communes, $communeId);
        $lat = (string)array_get($latlng, 'lat');
        $lng = (string)array_get($latlng, 'lng');
        if (empty($lat) || empty($lng)) {
            return [
                'lat' => '',
                'lng' => '',
            ];
        }

        $lat = substr($lat, 0, -4);
        $lng = substr($lng, 0, -4);
        $lat = $lat . rand(0, 9999);
        $lng = $lng . rand(0, 9999);

        return [
            'lat' => $lat,
            'lng' => $lng,
        ];

    }

    protected function _sync()
    {
        $file = "https://cuuhomientrung.info/api/app/hodan/?format=json";
        $data = file_get_contents($file);
        $data = json_decode($data, 1);
        $newData = [];

        foreach ($data as $key => $item) {
            $id = (int)array_get($item, 'id');
            $newData[$id] = $item;
        }

        $existed = Map::whereIn('sync_id', array_keys($newData))->select('sync_id')->get()->toArray();

        $existedArr = [];
        foreach ($existed as $e) {
            $existedArr[$e['sync_id']] = $e['sync_id'];
        }
        foreach ($newData as $item) {
            $id = (int)array_get($item, 'id');
            if (array_key_exists($id, $existedArr)) {
                continue;
            }
            $title = array_get($item, 'name') . ' - ' . array_get($item, 'phone');
            $latlng = $this->_getLocation($item);
            $entity = [
                'sync_id' => $id,
                'province_id' => (int)array_get($item, 'tinh'),
                'district_id' => (int)array_get($item, 'huyen'),
                'commune_id' => (int)array_get($item, 'xa'),
                'title' => $title,
                'description' => array_get($item, 'location') . "\r\n" . array_get($item, 'note'),
                'type' => $this->_convertStatus(array_get($item, 'status')),
                'lat' => array_get($latlng, 'lat'),
                'lng' => array_get($latlng, 'lng'),
            ];
            Map::create($entity);
        }
        return true;
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
        if (empty($address)) {
            return [
                'lat' => '',
                'lng' => '',
            ];
        }

        return [
            'lat' => '',
            'lng' => '',
        ];
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
