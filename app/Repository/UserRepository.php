<?php


namespace App\Repository;


class UserRepository
{
    public function getUsers(): array
    {
        return [
            [
                'name' => 'Ivan',
                'email' => 'ivan@test.com',
                'device_id' => 'Ks[dqweer4'
            ],
            [
                'name' => 'Peter',
                'email' => 'peter@test.com'
            ],
            [
                'name' => 'Mark',
                'device_id' => 'Ks[dqweer4'
            ],
            [
                'name' => 'Nina',
                'email' => '...'
            ],
            [
                'name' => 'Luke',
                'device_id' => 'vfehlfg43g'
            ],
            [
                'name' => 'Zerg',
                'device_id' => ''
            ],
            [
                'email' => '...',
                'device_id' => ''
            ]
        ];
    }
}