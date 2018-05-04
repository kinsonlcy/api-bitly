<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ShortenURL;

class ShortenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function test()
    {
      echo "it works!";
    }
    public function checkExist($url_var)
    {
      $url_id = array();
      $items = ShortenURL::where('url','=',$url_var)->get();
      //item exists, directly push the result to frontend
      if(sizeof($items) != 0){
        array_push($url_id,$items[0]['shorten_id']);
      }
      return $url_id;
    }

    public function get_result(Request $request)
    {
      $data = $request->all();
      $address = $data["url"];
      $domain = $request->root();
      //check the existing url, if have, return , skip
      $url_id = $this->checkExist($address);
      if(sizeof($url_id) != 0){
        $result = [
          'url' => $address,
          'shorten_url' =>  $domain . '/' . $url_id[0],
        ];
        return json_encode($result, JSON_FORCE_OBJECT);
      }

      $num = random_int(0, 0xffff);
      $id = Hashids::encode($num);
      $flag = true;
      while($flag){
        //check if the random generated id is exists
        $exists_id = ShortenURL::where('shorten_id','=',$id)->get();
        //regenerate random id if the same id is already exists
        if(sizeof($exists_id) != 0){
          $num = random_int(0, 0xffff);
          $id = Hashids::encode($num);
          continue;
        }
        $flag = false;
      }

      $id_url = ShortenURL::insertGetId(
        [
          'shorten_id' => $id,
          'url' => $address,
        ]
      );
      $result = [
        'url' => $address,
        'shorten_url' =>  $domain . '/' . $id,
      ];
      return json_encode($result, JSON_FORCE_OBJECT);
    }

    public function get_full_url(Request $request, $id)
    {
      $items = ShortenURL::where('shorten_id','=',$id)->pluck('url');
      if(sizeof($items) != 0){
        return redirect($items[0],301);
      }
      $domain = $request->root();
      return redirect($domain . "/bitly",301);

    }

}
