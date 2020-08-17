<?php
namespace App\Controller;

use App\Model\PersonModel;
use Cu\Controller\Controller;

class ApiPersonController extends Controller
{
    public function getAll($req, $res)
    {
        $ps = new PersonModel();
        $people = $ps->all();
        $res->response(200, $people['data']);
    }

    public function addPerson($req, $res)
    {
        $ps = new PersonModel();
        $data_request = $req->getData();

        $data_check = ["email" => $data_request['email']];
        $existing_people = $ps->get($data_check);

        if (!isset($existing_people['err'])) {
            if (count($existing_people['data']) > 0) {
                $res->response(500, ["err" => "Email is registered!", "column_err" => 'email']);
            } else {
                $data_request['is_active'] = 1;
                $result = $ps->add($data_request);
                if (!isset($result['err'])) {
                    $res->response(200, $result['data']);
                } else {
                    $res->response(500, $result);
                }
            }
        } else {
            $res->response(500, ["err" => "Can not add this person! Please try again!"]);
        }
    }

    public function updatePerson($req, $res, $id)
    {
        $ps = new PersonModel();
        $data_request = $req->getData();

        $data_check = ["email" => $data_request['email']];
        $existing_people = $ps->getExistingEmail($id, $data_check);

        if (!isset($existing_people['err'])) {
            if (count($existing_people['data']) > 0) {
                $res->response(500, ["err" => "Email is registered!", "column_err" => 'email']);
            } else {
                $result = $ps->edit($id, $req->getData());
                if (!isset($result['err'])) {
                    $res->response(200, $result);
                } else {
                    $res->response(500, $result);
                }
            }
        } else {
            $res->response(500, ["err" => "Can not edit this person! Please try again!"]);
        }

    }

    public function getUserByData($req, $res)
    {
        $ps = new PersonModel();
        $data_request = $req->getData();
        $data_check = ["email" => $data_request['email']];
        $existing_people = $ps->get($data_check);

        if (!isset($existing_people['err'])) {
            if (count($existing_people['data']) > 0) {
                $res->response(200, $existing_people['data']);
            } else {
                $res->response(500, ["err" => $data_check]);
            }
        } else {
            $res->response(500, ["err" => "Can not add this person! Please try again!"]);
        }
    }

    public function deltePerson($req, $res, $id)
    {
        $ps = new PersonModel();
        $result = $ps->delete($id);

        if (!isset($result['err'])) {
            $res->response(200, $result['data']);
        } else {
            $res->response(500, $result);
        }
    }
}
