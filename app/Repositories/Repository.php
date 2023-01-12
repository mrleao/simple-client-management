<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements IRepository {

    protected Model $model;

	protected const QTTY_RECORD_RETURN = 10;

	/**
	 * returns records according to the passed ID.
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function get(int $id) {
		return $this->model->find($id);
	}
    
	/**
	 * returns all records found.
	 *
	 * @return mixed
	 */
	function getAll() {
		return $this->model->paginate(self::QTTY_RECORD_RETURN);
	}
	
	/**
	 * creates a new record.
	 *
	 * @param array $data
	 *
	 * @return mixed
	 */
	function create(array $data) {
		return $this->model->create($data);
	}
	
	/**
	 * update a record by id
	 *
	 * @param int $id
	 * @param array $data
	 *
	 * @return mixed
	 */
	function update(int $id, array $data) {
		if (empty($this->model->find($id))) {
			return null;
		}
		return $this->model->find($id)->update($data);
	}
	
	/**
	 * returns records according to the param passed.
	 *
	 * @param string $column, $param
	 *
	 * @return mixed
	 */
	function getBy(string $column, string $param) {
		return $this->model->where($column, $param)->paginate(self::QTTY_RECORD_RETURN);
	}

	/**
	 * delete a record by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function delete(int $id) {
		if (empty($this->model->find($id))) {
			return null;
		}
		return $this->model->find($id)->delete();
	}
}