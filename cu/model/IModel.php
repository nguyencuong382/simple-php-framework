<?php
namespace Cu\Model;

interface IModel {
  function all();
  function add($data);
  function edit($id, $data);
  function delete($id);
}