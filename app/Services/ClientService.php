<?php

namespace App\Services;

use App\Helpers\CpfHelper;
use App\Helpers\DateHelper;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientService extends Service
{
    protected $repository;

    protected $dateHelper;

    protected $cpfHelper;

	public function __construct(ClientRepository $repository, DateHelper $dateHelper, CpfHelper $cpfHelper)
    {
        $this->repository = $repository;
        $this->dateHelper = $dateHelper;
        $this->cpfHelper = $cpfHelper;
    }

	/**
	 * creates a new record.
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	function create(Request $request) {

        $cpf = $this->cpfHelper->onlyNumbers($request->cpf);
        $newbirthDate = $this->dateHelper->toUsaFormat($request->birth_date);

        $request->request->add(['cpf' => $cpf, 'birth_date' => $newbirthDate]);

        try {
            $request->validate([
                'name' => 'required',
                'cpf'=> 'cpf|unique:clients,cpf|required',
                'birth_date' => 'required'
            ]);
        } catch (ValidationException $e) {
            $errors = [
                'errors' => $e->errors()
            ];
            return $this->hasErrorRequiredData($errors);
        }

		return $this->formatResponse($this->repository->create($request->all()));
	}
	
	/**
	 * update a record by id
	 *
	 * @param int $id
	 * @param Request $request
	 *
	 * @return mixed
	 */
	function update(int $id, Request $request) {

        $cpf = $this->cpfHelper->onlyNumbers($request->cpf);
        $newbirthDate = $this->dateHelper->toUsaFormat($request->birth_date);

        $request->request->add(['cpf' => $cpf, 'birth_date' => $newbirthDate]);

        try {
            $request->validate([
                'name' => 'required',
                'cpf'=> 'cpf|required|unique:clients,cpf,'.$id,
                'birth_date' => 'required'
            ]);
        } catch (ValidationException $e) {
            $errors = [
                'errors' => $e->errors()
            ];
            return $this->hasErrorRequiredData($errors);
        }

		$data = [
			'name' => $request->name,
			'cpf' => $request->cpf,
			'birth_date' => $request->birth_date,
			'phone_numbner' => $request->phone_numbner,
		];

		return $this->formatResponse($this->repository->update($id, $data));
	}
	
	/**
	 * returns records according to the param passed.
	 *
	 * @param string $column, $param
	 *
	 * @return mixed
	 */
	function getByLikeNameOrCpf(string $param) {
		if (is_numeric($param)) {
			$param = $this->cpfHelper->onlyNumbers($param);
		}
		return $this->formatResponse($this->repository->getByLikeNameOrCpf($param));
	}
}