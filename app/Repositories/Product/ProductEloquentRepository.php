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
            'slug' => str_slug($data['title']),
            'user_id' => $data['user_id'],
            'body' => $data['body'],
            'price' => $data['price'],
            'new_price' => $data['new_price'],
            'price_start' => $data['start_price'],
            'price_end' => $data['end_price']
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
            'body' => $data['body'],
            'price' => $data['price'],
            'new_price' => $data['new_price'],
            'price_start' => $data['start_price'],
            'price_end' => $data['end_price']
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
    public function getAll($with = null, $paginate = null)
    {
        if($with && $paginate) {
            $result = $this->_model->with($with)->orderBy('created_at', 'desc')->paginate($paginate);
        }elseif($with) {
            $result = $this->_model->with($with)->orderBy('created_at', 'desc')->get();
        }elseif($paginate) {
            $result = $this->_model->orderBy('created_at', 'desc')->paginate($paginate);
        }else{
            $result = $this->_model->orderBy('created_at', 'desc')->get();
        }        
        return $result;
    }



    /**
     * get product only published
     * @param $id ini Product ID
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->where('id', $id)->first();
        return $result;
    }

    public function findByUidAndSlug($uid, $slug) {
        $owner = \App\User::where('slug', $uid)->first();
        return $this->_model->with('user')->where('slug', $slug)->where('user_id', $owner->id)->first();
    }

}
