<?php

namespace Cu\Http;

interface IResponse
{
  function response($status_code, $data = null);
}
