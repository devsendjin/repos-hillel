<?php


namespace App\Repository\User;


use PDO;
use App\Model\User\{User, UserInterface};

final class PdoUserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    /**
     * Variable stores user id, that was not found in database
     * @var int
     */
    private int $temporaryId;

    /**
     * PdoUserRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param int $id
     * @return UserInterface
     */
    public function find(int $id): UserInterface
    {
        $sql = 'select * from `users` where id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) $this->temporaryId = $id;
        return new User($data['id'], $data['email']);
    }

    /**
     * @param UserInterface $user
     */
    public function delete(UserInterface $user): void
    {
        $sql = 'delete from `users` where `id` = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $user->getId());
        $stmt->execute();
    }

    /**
     * @param UserInterface $user
     */
    public function save(UserInterface $user): void
    {
        if ($user->getId()) {
            $sql = 'update `users` set email = :email where id = :id';
            $fields = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ];
            $this->recordToDb($sql, $fields);
        } else {
            $sql = 'insert into `users` set email = :email, id = :id';
            $fields = [
                'id' => $this->temporaryId,
                'email' => $user->getEmail(),
            ];
            $this->recordToDb($sql, $fields);
        }
    }

    /**
     * @param string $sql
     * @param array $fields
     */
    private function recordToDb(string $sql, array $fields): void
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($fields as $fieldName => $fieldValue) {
            $$fieldName = $fieldValue; // creating variable name according to field name
            $stmt->bindParam($fieldName, $$fieldName);
        }
        $stmt->execute();
    }
}