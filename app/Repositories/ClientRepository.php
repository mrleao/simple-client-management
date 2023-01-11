<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository extends Repository
{
	public function __construct(Client $model)
    {
        $this->model = $model;
    }

    public function getByLikeNameOrCpf(string $param){
		return $this->model->where('name', 'like', "%$param%")->orWhere('cpf', 'like', "%$param%")->paginate(10);
    }
}