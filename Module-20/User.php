<?php

class User
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=localhost;dbname=task20;charset=utf8", 'root', 'Root1234');
    }

    public function create(array $dataUser)
    {
        ['email' => $email, 'first_name' => $first_name, 'last_name' => $last_name, 'age' => $age] = $dataUser;

        $state = $this->connection
            ->prepare("INSERT INTO `Users` (
                                `email`,
                                `first_name`,
                                `last_name`, 
                                `age`,
                                `date_created`
                            )
                            VALUES (
                                :email,
                                :first_name,
                                :last_name,
                                :age,
                                NOW()
                            )"
            );
        $state->execute([
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'age' => $age
        ]);
    }

    public function update(array $data, int $id)
    {
        ['email' => $email, 'first_name' => $first_name, 'last_name' => $last_name, 'age' => $age] = $data;
        $state = $this->connection
            ->prepare("UPDATE `Users`
                            SET email = :email,
                                first_name = :first_name,
                                last_name = :last_name,
                                age = :age,
                                date_created = NOW()
                            WHERE id = '${id}'"
            );
        $state->execute([
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'age' => $age
        ]);
    }

    public function delete(int $id)
    {
        $state = $this->connection
            ->prepare("DELETE FROM `Users` WHERE id='${id}'");
        $state->execute();
    }

    public function list()
    {
        $state = $this->connection
            ->prepare("SELECT * FROM `Users`");
        $state->execute();
        return $state->fetchAll(PDO::FETCH_ASSOC);
    }
}
