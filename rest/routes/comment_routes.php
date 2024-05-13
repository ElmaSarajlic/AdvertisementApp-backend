<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/CommentService.class.php';

Flight::set('comment_service', new CommentService());

Flight::group('/comments', function() {

    /**
     * @OA\Get(
     *      path="/comments",
     *      tags={"comments"},
     *      summary="Get all comments",
     *      @OA\Response(
     *           response=200,
     *           description="Array of all comments in the database"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $comment_service = Flight::get('comment_service');
        Flight::json($comment_service->get_all_comments());
    });

    /**
     * @OA\Get(
     *      path="/comments/{id}",
     *      tags={"comments"},
     *      summary="Get comment by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Comment object"
     *      )
     * )
     */
    Flight::route('GET /@id', function($id) {
        $comment_service = Flight::get('comment_service');
        Flight::json($comment_service->get_comment_by_id($id));
    });

    /**
     * @OA\Post(
     *      path="/comments",
     *      tags={"comments"},
     *      summary="Add a new comment",
     *      @OA\RequestBody(
     *          description="Comment data",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"content", "user_id", "ad_id"},
     *              @OA\Property(property="content", type="string", example="This is a comment."),
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="ad_id", type="integer", example=1)
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Comment added"
     *      )
     * )
     */
    Flight::route('POST /', function() {
        $data = Flight::request()->data->getData();
        $comment_service = Flight::get('comment_service');
        Flight::json($comment_service->add_comment($data));
    });

    /**
     * @OA\Put(
     *      path="/comments/{id}",
     *      tags={"comments"},
     *      summary="Update comment by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          description="Comment data",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"content"},
     *              @OA\Property(property="content", type="string", example="Updated comment content.")
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Comment updated"
     *      )
     * )
     */
    Flight::route('PUT /@id', function($id) {
        $data = Flight::request()->data->getData();
        $comment_service = Flight::get('comment_service');
        $comment_service->update_comment($id, $data);
        Flight::json(['message' => 'Comment updated successfully']);
    });

    /**
     * @OA\Delete(
     *      path="/comments/{id}",
     *      tags={"comments"},
     *      summary="Delete comment by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Comment deleted"
     *      )
     * )
     */
    Flight::route('DELETE /@id', function($id) {
        $comment_service = Flight::get('comment_service');
        $comment_service->delete_comment_by_id($id);
        Flight::json(['message' => 'Comment deleted successfully']);
    });

});
