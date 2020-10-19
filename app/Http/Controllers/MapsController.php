<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MapRequest;
use App\Map;

class MapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = Map::all();
        $lat = session('lat', 16.8014069);
        $lng = session('lng', 107.053141);

        return view('maps')->with('data', $maps)->with('lat', $lat)->with('lng', $lng);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store()
    {
        $id = \request('id');
        if ($id) {
            $entity = Map::where('id', $id)->first();
            if (empty($entity)) {
                return response()->json(['status' => false, 'message' => 'Bản ghi không tồn tại!']);
            }
        }

        if (empty(\request('title'))) {
            return response()->json(['status' => false, 'message' => 'Bạn cần nhập tên người cần cứu trợ!']);
        }

        if (empty(\request('description'))) {
            return response()->json(['status' => false, 'message' => 'Bạn cần nhập ghi chú!']);
        }

        if (empty(\request('lat'))) {
            return response()->json(['status' => false, 'message' => 'Bạn cần nhập lat!']);
        }

        if (empty(\request('lng'))) {
            return response()->json(['status' => false, 'message' => 'Bạn cần nhập lng!']);
        }

        $data = [
            'title' => \request('title'),
            'description' => \request('description'),
            'type' => \request('type'),
            'lng' => \request('lng'),
            'lat' => \request('lat'),
        ];
        if (isset($entity)) {
            $entity->fill($data)->save();
        } else {
            Map::create($data);
        }
        session()->put('lat', $data['lat']);
        session()->put('lng', $data['lng']);
        return response()->json(['status' => true, 'message' => 'OK']);
    }
}
