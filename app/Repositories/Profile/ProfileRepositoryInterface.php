<?php
namespace App\Repositories\Profile;

interface ProfileRepositoryInterface
{

    public function getbySlug($slug);

    public function getAuth($id);

    public function filterData($data);

}