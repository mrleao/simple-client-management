<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends Repository
{
	public function __construct(Client $model)
    {
        $this->model = $model;
    }
}