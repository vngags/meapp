<?php
namespace App\Repositories\Product;

interface ProductRepositoryInterface
{

    /**
     * get all product only published
     * @return mixed
     */
    // public function getAllPublished();


    /**
     * get product only published
     * @return mixed
     */
    // public function findOnlyPublished();

    public function findByUidAndSlug($uid, $slug);

}