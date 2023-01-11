<?php

namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Http\Request;

abstract class Service {

    protected $repository;

	/**
	 * returns records according to the passed ID.
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function get(int $id) {
		return $this->repository->get($id);
	}
    
	/**
	 * returns all records found.
	 *
	 * @return mixed
	 */
	function getAll() {
		return $this->repository->getAll();
	}
	
	/**
	 * delete a record by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function delete(int $id) {
		return $this->repository->delete($id);
	}

    public function formatResponse($data, $msg = null)
    {
        if (empty($data) || (is_countable($data) && count($data) == 0)) {
            return $this->hasEmptyData('Registro não encontrato');
        }

        return $this->hasSuccessData($data, $msg != null ?? 'Sucesso');
    }

    public function hasErrorRequiredData($errors)
    {
        return response([
            'success' => false,
            'code' => 422,
            'message' => 'Parâmetros inválidos',
            'data' => $errors
        ], 422);
    }
    
    public function hasErrorConflictedData(String $message)
    {
        return response([
            'success' => true,
            'code' => 409,
            'message' => $message,
            'data' => null
        ], 409);
    }

    public function hasEmptyData(String $message)
    {
        return response([
            'success' => true,
            'code' => 404,
            'message' => $message,
            'data' => null
        ], 404);
    }

    public function hasSuccessData($data, String $message)
    {
        return response([
            'success' => true,
            'code' => 200,
            'message' => $message,
            'data' => $data
        ], 200);
    }
}