<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements IRepository {

    protected Model $model;

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
		return $this->model->all();
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
		return $this->model->where($column, $param)->get();
	}

	/**
	 * delete a record by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	function delete(int $id) {
		return $this->model->find($id)->delete();
	}
}