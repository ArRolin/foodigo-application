<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Category\Entities\Category;
use App\Http\Controllers\Api\BaseController;

class RestaurantCategoryController extends BaseController
{
    public function categoryList()
    {
        try {
            $categories = Category::latest()->get();

            $data = [
                'categories' => $categories
            ];

            return $this->sendResponse($data, 'Category list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Something went wrong', [], 500);
        }
    }
}
