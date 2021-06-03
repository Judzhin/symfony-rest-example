<?php


namespace App\UseCase\Post\Create;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Handler
 * @package App\UseCase\Post\Create
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
        $post = Post::create($command->name, $command->description);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}