<?php

namespace App\Services;

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
		return $this->formatResponse($this->repository->get($id));
	}
    
	/**
	 * returns all records found.
	 *
	 * @return mixed
	 */
	function getAll() {
		return $this->formatResponse($this->repository->getAll());
	}
	
	/**
	 * delete a record by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function delete(int $id) {
		return $this->formatResponse($this->repository->delete($id));
	}

    public function formatResponse($data)
    {
        if (empty($data) || (is_countable($data) && count($data) == 0)) {
            return $this->hasEmptyData('Nenhum registro encontrado');
        }

        return $this->hasSuccessData($data, 'Sucesso');
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