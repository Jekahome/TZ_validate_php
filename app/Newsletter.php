<?php

declare(strict_types = 1);

namespace App;

use App\Repository\IUserRepository;
use App\Validate\IValidator;

class Newsletter
{
    private IUserRepository $repository;
    private IValidator $validator;

    public function __construct(IUserRepository $repository,IValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function send(): void
    {

        $users = $this->repository::getUsers();
        $uniqueSent = [];

        foreach ($users as $user) {

            if (isset($user['name']) && isset($user['email']) && isset($user['device_id']) ){
                if(!array_key_exists($user['email'],$uniqueSent) && !in_array($user['device_id'],$uniqueSent,true)){

                    $this->validator->activateField('name', $user['name']);
                    $this->validator->activateField('email', $user['email']);
                    $this->validator->activateField('device_id', $user['device_id']);
                    $this->validator->validate();

                    if($this->validator->isValidate()){
                        $uniqueSent[$user['email']]=$user['device_id'];

                        echo str_replace(["{email}","{name}"], [$user['email'],$user['name']],
                            "Email {email} has been sent to user {name}\n");
                    }
                    $this->validator->reset();
                }
            }


        }

    }

    public function notify(): void{
        $users = $this->repository::getUsers();
        $uniqueSent = [];

        foreach ($users as $user) {

            if (isset($user['name']) && isset($user['email']) && isset($user['device_id']) ){
                if(!array_key_exists($user['email'],$uniqueSent) && !in_array($user['device_id'],$uniqueSent,true)){

                    $this->validator->activateField('name', $user['name']);
                    $this->validator->activateField('email', $user['email']);
                    $this->validator->activateField('device_id', $user['device_id']);
                    $this->validator->validate();

                    if($this->validator->isValidate()){
                        $uniqueSent[$user['email']]=$user['device_id'];

                        echo str_replace(["{email}","{name}","{device_id}"], [$user['email'],$user['name'],$user['device_id']],
                            "Push notification has been sent to user {name} with device_id {device_id}\n");
                    }
                    $this->validator->reset();
                }
            }

        }

    }
}