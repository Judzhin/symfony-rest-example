<?php
/**
 * @access protected
 */

namespace App\Controller;


use App\Entity\Post;
use App\Repository\PostRepository;
use App\UseCase\Post\Create;
use App\UseCase\Post\Update\Command;
use App\UseCase\Post\Update\Handler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 *
 * @package App\Controller
 * @Route("/api", name="post_api")
 */
class PostController extends AbstractController
{
    use RestController;

//    /**
//     * @Route("/posts", name="posts", methods={"GET"})
//     *
//     * @param PostRepository $posts
//     * @return JsonResponse
//     */
//    public function getPosts(PostRepository $posts): JsonResponse
//    {
//        return $this->createResponse([
//            'success' => true,
//            'data' => $posts->findAll(),
//            'total' => $posts->count([])
//        ]);
//    }
//
//    /**
//     * @Route("/posts", name="posts_add", methods={"POST"})
//     *
//     * @param Request $request
//     * @param Create\Handler $handler
//     *
//     * @return JsonResponse
//     */
//    public function addPost(Request $request, Create\Handler $handler): JsonResponse
//    {
//        /** @var Request $request */
//        $request = $this->transformJsonBody($request);
//
//        /** @var Create\Command $command */
//        $command = new Create\Command;
//        $command->name = $request->request->get('name');
//        $command->description = $request->request->get('description');
//
//        try {
//            /** @var Post $post */
//            $post = $handler->handle($command);
//            return $this->respondCreated([
//                'success' => true,
//                'data' => [$post]
//            ]);
//        } catch (\DomainException $exception) {
//            return $this->respondValidationError($exception->getMessage());
//        }
//    }
//
//    /**
//     * @Route("/posts/{id}", name="posts_get", methods={"GET"})
//     *
//     * @param PostRepository $repository
//     * @param $id
//     *
//     * @return JsonResponse
//     */
//    public function getPost(PostRepository $repository, $id): JsonResponse
//    {
//        /** @var Post $post */
//        if ($post = $repository->find($id)) {
//            return $this->createResponse([
//                'success' => true,
//                'data' => [$post]
//            ]);
//        }
//
//        return $this->respondNotFound("Post not found");
//    }
//
//    /**
//     * @Route("/posts/{id}", name="posts_put", methods={"PUT"})
//     *
//     * @param Request $request
//     * @param PostRepository $repository
//     * @param $id
//     * @param Handler $handler
//     *
//     * @return JsonResponse
//     */
//    public function updatePost(Request $request, PostRepository $repository, $id, Handler $handler)
//    {
//
//        try {
//
//            /** @var Request $request */
//            $request = $this->transformJsonBody($request);
//
//            /** @var Command $command */
//            $command = new Command;
//            $command->id = $id;
//            $command->name = $request->get('name');
//            $command->description = $request->get('description');
//
//            /** @var Post $post */
//            $post = $handler->handle($command);
//
//            return $this->createResponse([
//                'success' => true,
//                'data' => [$post]
//            ]);
//
//            if (!$post) {
//                $data = [
//                    'status' => 404,
//                    'errors' => "Post not found",
//                ];
//                return $this->createResponse($data, 404);
//            }
//
//            $post->setName($request->get('name'));
//            $post->setDescription($request->get('description'));
//            $entityManager->flush();
//
//        } catch (\Exception $e) {
//            $data = [
//                'status' => 422,
//                'errors' => "Data no valid",
//            ];
//            return $this->createResponse($data, 422);
//        }
//
//    }
//
//
//    /**
//     * @param PostRepository $postRepository
//     * @param $id
//     * @return JsonResponse
//     * @Route("/posts/{id}", name="posts_delete", methods={"DELETE"})
//     */
//    public function deletePost(EntityManagerInterface $entityManager, PostRepository $postRepository, $id)
//    {
//        $post = $postRepository->find($id);
//
//        if (!$post) {
//            $data = [
//                'status' => 404,
//                'errors' => "Post not found",
//            ];
//            return $this->createResponse($data, 404);
//        }
//
//        $entityManager->remove($post);
//        $entityManager->flush();
//        $data = [
//            'status' => 200,
//            'errors' => "Post deleted successfully",
//        ];
//        return $this->createResponse($data);
//    }
}
