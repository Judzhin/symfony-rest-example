<?php


namespace App\UseCase\Post\Update;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Handler
 *
 * @package App\UseCase\Post\Update
 */
class Handler
{
    /**
     * Handler constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @param Command $command
     * @return Post
     */
    public function handle(Command $command): Post
    {
        /** @var Post $post */
        $post = $this->entityManager->find(Post::class, $command->id);

        $post
            ->setName($command->name)
            ->setDescription($command->description);

        $this->entityManager->flush();

        return $post;
    }
}