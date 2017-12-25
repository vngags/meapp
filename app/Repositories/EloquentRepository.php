<?php
namespace App\Repositories;

abstract class EloquentRepository implements RepositoryInterface
{

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;
    

    public function __construct()
    {
        $this->setModel();
    }


    /**
     * get model
     * @return string
     */
    abstract public function getModel();


    /**
     * set model
     */
    public function setModel()
    {
        $this->_model = app()->make( $this->getModel() );
    }


    /**
     * get all
     * @return \Illuminate\Database\Eloquent\Collection\static[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }


    /**
     * get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);
        return $result;
    }


    /**
     * create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }


    /**
     * update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }


    /**
     * delete
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if($result) {
            $result->delete();
            return true;
        }
        return false;
    }

}