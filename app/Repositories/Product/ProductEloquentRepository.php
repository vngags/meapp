<?php
namespace App\Repositories\Product;

use App\Repositories\EloquentRepository;

class ProductEloquentRepository extends EloquentRepository implements ProductRepositoryInterface
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Product::class;
    }

    public function create(array $data)
    {
        $product = $this->_model->create([
            'title' => $data['title'],
            'user_id' => $data['user_id'],
            'body' => $data['body']
        ]);
        if($data['attachments'] && count($data['attachments']) > 0) {
            $product->attachments()->sync($data['attachments']);
        }
        return $product;
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update([
            'title' => $data['title'],
            'user_id' => $data['user_id'],
            'body' => $data['body']
        ]);
        if($data['attachments'] && count($data['attachments']) > 0) {
            $product->attachments()->sync($data['attachments']);
        }
        return $product;
    }


    /**
     * get all product only published
     * @return mixed
     */
    public function getAll()
    {
        // $result = $this->_model->where('is_published', 1)->get();
        $result = $this->_model->get();
        return $result;
    }


    /**
     * get product only published
     * @param $id ini Product ID
     * @return mixed
     */
    public function find($id)
    {
        // $result = $this->_model->where('id', $id)->where('is_published', 1)->first();
        $result = $this->_model->where('id', $id)->first();
        return $result;
    }



}
