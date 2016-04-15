<?php

namespace App\Services;

use Auth;
Use App\Services\EmailServices;
use App\Models\User;
use Session;

class UserService
{

    const EMAIL = 'email';
    const FB = 'fb';
    const GOOGLE = 'google';

    public function __construct( User $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser( $data )
    {
        if ($data['type'] == self::EMAIL) {
            $user = $this->registerByEmail($data);
        } else {
            $user = $this->registerBySocial($data);
        }

//        $this->emailServices->welcomeEmail($user);
        return $user;
    }

    private function registerByEmail( $userData )
    {
        $user = $this->userRepository->add($userData);
        $this->logUser($user);
        return $user;
    }

    public function updateBySocial( $user, $socialData, $type )
    {
        $propertyId = $type . "_id";
        if (empty($user->{$propertyId})) {
            $dataUser[$type . '_id'] = $socialData->id;
        }

        $dataUser[$type . '_token'] = $socialData->token;
        if ($type == self::FB) {
            $dataUser[$type . '_image'] = "http://graph.facebook.com/" . $socialData->id . "/picture?width=255";
        } else if ($type == self::GOOGLE) {
            $dataUser[$type . '_image'] = str_replace('?sz=50', '?sz=255', $socialData->avatar);
        }

        $user->update($dataUser);
    }

    private function registerBySocial( $data )
    {
        $user = $data['user'];
        $type = $data['type'];

        $userData[$type . '_id'] = $user->id;
        $userData[$type . '_token'] = $user->token;

        if ($type == self::FB) {
            $userData[$type . '_image'] = "http://graph.facebook.com/" . $user->id . "/picture?width=255";
            $userData['name'] = $user->user['first_name'];
            $userData['lastname'] = $user->user['last_name'];
        } else if ($type == self::GOOGLE) {
            $userData[$type . '_image'] = str_replace('?sz=50', '?sz=255', $user->avatar);
            $userData['name'] = $user->user['name']['givenName'];
            $userData['lastname'] = $user->user['name']['familyName'];
        }

        $userData['email'] = $user->email;
        //$userData['sex'] = isset($user->user['gender']) && ($user->user['gender'] == 'female' ) ? 1 : 2;
        $userData['status'] = 1;

        return $this->userRepository->add($userData);
    }

    public function updateUser( $user, $userData )
    {
        $error = [];

        $checkEmail = $this->userRepository->checkEmail($userData['email'], $user);
        if (!empty($checkEmail)) {
            $error[] = [
                'field' => 'email',
                'error' => '#edit-enter-mail-exist'
            ];
        }

        if (empty($error)) {
            $user->update($userData);
            Auth::setUser($user);
            return $user;
        }

        return ['success' => false, 'errors' => $error];
    }

    public function logUser( $user )
    {
        if ($user->status == 1) {
            Auth::loginUsingId($user->id);
        } else {
            Session::set('error_log_user', true);
        }
    }

}
