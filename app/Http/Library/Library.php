<?php

namespace App\Http\Library;

trait Library
{
    /**
     * Check if the user has admin rule
     *
     * @param \App\Models\User $user user connecté
     *
     * @return bool
     */
    protected function isAdmin($user)
    {
        if (!empty($user) && strcmp($user->rule, "admin") == 0) {
            return true;
        }
        return false;
    }

    /**
     * Check if the user has Director rule
     *
     * @param \App\Models\User $user user connecté
     *
     * @return bool
     */
    protected function isDirector($user)
    {
        if (!empty($user) && strcmp($user->rule, "director") == 0) {
            return true;
        }
        return false;
    }

    /**
     * Check if the user has Operator rule
     *
     * @param \App\Models\User $user user connecté
     *
     * @return bool
     */
    protected function isOperator($user)
    {
        if (!empty($user) && strcmp($user->rule, "operator") == 0) {
            return true;
        }
        return false;
    }

    /**
     * Check if the user is recognize by the system
     *
     * @param \App\Models\User $user user connecté
     *
     * @return bool
     */
    protected function isRecognized($user)
    {
        if (!empty($user)) {
            switch ($user->rule) {
                case 'admin':
                    return true;
                    break;
                case 'director':
                    return true;
                    break;
                case 'operator':
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }
        return false;
    }
}
