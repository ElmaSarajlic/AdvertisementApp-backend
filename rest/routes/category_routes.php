<?php

require_once __DIR__ . '/../services/CategoryService.class.php';

/**
 * @OA\Info(title="Category API", version="1.0.0")
 */
Flight::group('/categories', function () {

    /**
     * @OA\Get(
     *     path="/categories/all",
     *     summary="Get all categories",
     *     tags={"categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of all categories",
     *         @OA\JsonContent(type="array", @OA\Items(type="object", example={"id": 1, "name": "Fiction", "description": "Books that contain imaginary stories"}))
     *     )
     * )
     */
    Flight::route('GET /all', function () {
        $category_service = new CategoryService();
        $categories = $category_service->get_all_categories();
        Flight::json($categories);
    });

    /**
     * @OA\Get(
     *     path="/categories/{id}",
     *     summary="Get category by ID",
     *     tags={"categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of category",
     *         @OA\JsonContent(type="object", example={"id": 1, "name": "Fiction", "description": "Books that contain imaginary stories"})
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    Flight::route('GET /@id', function ($id) {
        $category_service = new CategoryService();
        $category = $category_service->get_category_by_id($id);
        if ($category) {
            Flight::json($category);
        } else {
            Flight::halt(404, 'Category not found');
        }
    });

    /**
     * @OA\Post(
     *     path="/categories/add",
     *     summary="Add a new category",
     *     tags={"categories"},
     *     @OA\RequestBody(
     *         description="Category data to be added",
     *         required=true,
     *         @OA\JsonContent(type="object", example={"title": "Non-fiction"})
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category successfully added",
     *         @OA\JsonContent(type="object", example={"id": 2, "title": "Non-fiction"})
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to add category"
     *     )
     * )
     */
    Flight::route('POST /add', function () {
        $data = Flight::request()->data->getData();
        $category_service = new CategoryService();
        $category = $category_service->add_category($data);
        if ($category) {
            Flight::json($category, 201);
        } else {
            Flight::halt(400, 'Failed to add category');
        }
    });

    /**
     * @OA\Put(
     *     path="/categories/update/{id}",
     *     summary="Update an existing category",
     *     tags={"categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data for updating the category",
     *         required=true,
     *         @OA\JsonContent(type="object", example={"title": "Historical Fiction"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category successfully updated",
     *         @OA\JsonContent(type="object", example={"id": 1, "title": "Historical Fiction"})
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Failed to update category"
     *     )
     * )
     */
    Flight::route('PUT /update/@id', function ($id) {
        $data = Flight::request()->data->getData();
        $category_service = new CategoryService();
        $category = $category_service->update_category($id, $data);
        if ($category) {
            Flight::json($category);
        } else {
            Flight::halt(400, 'Failed to update category');
        }
    });

    /**
     * @OA\Delete(
     *     path="/categories/delete/{id}",
     *     summary="Delete a category by ID",
     *     tags={"categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the category to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category successfully deleted",
     *         @OA\JsonContent(type="object", example={"message": "Category successfully deleted"})
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found or could not be deleted"
     *     )
     * )
     */
    Flight::route('DELETE /delete/@id', function ($id) {
        $category_service = new CategoryService();
        $success = $category_service->delete_category_by_id($id);
        if ($success) {
            Flight::json(['message' => 'Category successfully deleted'], 200);
        } else {
            Flight::halt(404, 'Category not found or could not be deleted');
        }
    });
});