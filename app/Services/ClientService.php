<?php

namespace App\Services;

use App\Helpers\FormatHelper;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClientService extends Service
{
    protected $repository;

    protected $formatHelper;

	public function __construct(ClientRepository $repository, FormatHelper $formatHelper)
    {
        $this->repository = $repository;
        $this->formatHelper = $formatHelper;
    }

	/**
	 * creates a new record.
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	function create(Request $request) {

        $cpf = !$request->cpf ? '' : $this->formatHelper->onlyNumbers($request->cpf);
        $phoneNumber = !$request->phone_number ? '' : $this->formatHelper->onlyNumbers($request->phone_number);
        $newBirthDate = !$request->birth_date ? '' : $this->formatHelper->toUsaFormat($request->birth_date);

        $request->request->add(
			[
				'cpf' => $cpf, 
				'phone_number' => $phoneNumber,
				'birth_date' => $newBirthDate,
			]
		);
		
        try {
			$request->validate([
				'name' => 'required',
				'birth_date' => 'required',
				'cpf'=> 'cpf|unique:clients,cpf,|required',
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

        $cpf = $this->formatHelper->onlyNumbers($request->cpf);
        $newBirthDate = $this->formatHelper->toUsaFormat($request->birth_date);

        $request->request->add(['cpf' => $cpf, 'birth_date' => $newBirthDate]);

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
			$param = $this->formatHelper->onlyNumbers($param);
		}
		return $this->formatResponse($this->repository->getByLikeNameOrCpf($param));
	}
}