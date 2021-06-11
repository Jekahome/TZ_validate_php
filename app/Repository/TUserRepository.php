<?php
declare(strict_types = 1);

namespace App\Repository;

trait TUserRepository{
    static function getUsers(): \Generator{
        $users = (new UserRepository())->getUsers();
        foreach ($users as $user){
            yield $user;
        }
    }
}