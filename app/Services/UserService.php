<?php

namespace App\Services;

use Auth;
use Potoroze\Users\EloquentUserRepository;
use Potoroze\Services\EmailService;
use Potoroze\Services\SmartFocusService;
use Session;

class UserService
{

    const EMAIL = 'email';
    const FB = 'fb';
    const GOOGLE = 'google';

    public function __construct(
    EloquentUserRepository $userRepository, EmailService $emailservice, SmartFocusService $smartFocusService )
    {

        $this->userRepository = $userRepository;
        $this->emailServices = $emailservice;
        $this->smartFocusService = $smartFocusService;
    }

    public function registerUser( $data )
    {
        if ($data['type'] == self::EMAIL) {
            $user = $this->registerByEmail($data['user']);
        } else {
            $user = $this->registerBySocial($data);
        }
        $this->smartFocusService->addUser($user->email, $user->name, $user->surnames, $user->sex, 'ACCOUNT');
        $this->emailServices->welcomeEmail($user);
        return $user;
    }

    private function registerByEmail( $userData )
    {
        return $this->userRepository->add($userData);
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
            $userData['surnames'] = $user->user['last_name'];
        } else if ($type == self::GOOGLE) {
            $userData[$type . '_image'] = str_replace('?sz=50', '?sz=255', $user->avatar);
            $userData['name'] = $user->user['name']['givenName'];
            $userData['surnames'] = $user->user['name']['familyName'];
        }

        $userData['email'] = $user->email;
        $userData['sex'] = isset($user->user['gender']) && ($user->user['gender'] == 'female' ) ? 1 : 2;
        $userData['status'] = 1;

        $name = str_replace(' ', '', $userData['name']);
        $nickname = !empty($user->nickname) ? $user->nickname : $name . $userData['surnames'];
        $userData['nickname'] = $this->getNickname($nickname);

        return $this->userRepository->add($userData);
    }

    public function getNickname( $nickname )
    {
        $exitNick = $this->userRepository->findUserNickname($nickname);

        if (!empty($exitNick->items)) {
            $num = count($exitNick) + 1;
            $nickname = $nickname . $num;
        }

        return $nickname;
    }

    public function updateUser( $user, $userData )
    {
        $checkNickname = $this->userRepository->checkNickname($userData['nickname'], $user);
        $error = [];
        if (!empty($checkNickname)) {
            $error[] = [
                'field' => 'nickname',
                'error' => '#edit-enter-pseudo-exist'
            ];
        }

        $checkEmail = $this->userRepository->checkEmail($userData['email'], $user);
        if (!empty($checkEmail)) {
            $error[] = [
                'field' => 'email',
                'error' => '#edit-enter-mail-exist'
            ];
        }

        if (empty($error)) {
            $user->update($userData);
            return ['success' => true];
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
