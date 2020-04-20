<?php


namespace App\Repository\User;


use App\Model\User\{User, UserInterface};
use MongoDB\{Collection, Client};

final class MongoUserRepository implements UserRepositoryInterface
{
    private Client $client;

    /**
     * Variable stores user id, that was not found in database
     * @var int
     */
    private int $temporaryId;

    /**
     * MongoUserRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $id
     * @return UserInterface
     */
    public function find(int $id): UserInterface
    {
        $collection = $this->getCollection();
        $data = $collection->findOne(['id' => $id]);
        if (!$data) $this->temporaryId = $id;
        return new User($data->id, $data->email);
    }

    /**
     * @param UserInterface $user
     */
    public function delete(UserInterface $user): void
    {
        $collection = $this->getCollection();
        $collection->deleteOne(["id" => $user->getId()]);
    }

    /**
     * @param UserInterface $user
     */
    public function save(UserInterface $user): void
    {
        $collection = $this->getCollection();
        if ($user->getId()) {
            $collection->updateOne(
                ['id' => $user->getId()], // filter
                [ '$set' => [ 'email' => $user->getEmail() ]], // fields to update
            );
        } else {
            $collection->insertOne([
                'id' => $this->temporaryId,
                'email' => $user->getEmail(),
            ]);
        }
    }

    /**
     * @return Collection
     */
    private function getCollection(): Collection {
        return $this->client->blog->users;
    }
}
