<?php
namespace App\Controller\Search;

use App\Model\PersonModel;
use Cu\Controller\Controller;

class SearchController extends Controller
{
    public function getPeopByName($req, $res)
    {
        $ps = new PersonModel();
        if (!isset($req->params['name'])) {
            $res->response(500, ["err" => "Requried pramaters 'name'"]);
            return;
        }

        $searchingName = $req->params['name'];
        $result = $ps->getPeopleByName($searchingName);

        if (isset($result['err'])) {
            $res->response(500, ["err" => "Failed to get people named '$searchingName'"]);
        } else {
            $res->response(200, $result['data']);
        }

    }

    public function getLabelPeople($req, $res)
    {
        $ps = new PersonModel();
        $result = $ps->getPeopleByName("");

        if (isset($result['err'])) {
            $res->response(500, ["err" => "Failed to get people named '$searchingName'"]);
            return;
        }

        $response_data = array();
        foreach ($result['data'] as $value) {
            array_push($response_data, ["label" => $value['full_name']]);
        }

        if(count($response_data) > 0) {
          $res->response(200, $response_data);

        } else {
          $res->response(500, ["err" => "Data empty!"]);
        }
    }
}
