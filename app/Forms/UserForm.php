<?php

namespace App\Forms;

use Illuminate\Validation\Rules\Password;
use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    protected $clientValidationEnabled = false;

    /**
     * Formulaire de gestion des utilisateurs
     *
     * @return \Kris\LaravelFormBuilder\Form
     */
    public function buildForm()
    {
        $this->add(
            'name',
            'text',
            [
                'label' => "User name",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Username here"
                ],
                'rules' => [
                    'required',
                    'string',
                    'max:50',
                ],
                'error_messages' => [
                    'name.required' => "Username is required.",
                    'name.string' => "Username must be a string.",
                    'name.max' => "The max characters allowed is :max.",
                ]
            ]
        )->add(
            'email',
            'email',
            [
                'label' => "E-mail address",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "E-mail address here",
                ],
                'rules' => [
                    'required',
                    'string',
                    'email',
                    'unique:users',
                ],
                'error_messages' => [
                    'email.required' => "E-mail address is required.",
                    'email.string' => "E-mail address must be a string.",
                    'email.email' => "Invalid E-mail format.",
                    'email.unique' => "E-mail already taken, please change it.",
                ]
            ]
        )->add(
            'password',
            'password',
            [
                'label' => "User password",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Password here"
                ],
                'rules' => [
                    Password::min(8)
                        ->letters()
                        ->numbers()
                        ->mixedCase()
                        ->symbols()
                ]
            ]
        )->add(
            'rule',
            'choice',
            [
                'label' => "User rule",
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'admin' => 'Admin',
                    'director' => 'Director',
                    'oprator' => 'Operator',
                ],
                'default_value' => 'director'
            ]
        )->add(
            'submit',
            'submit',
            [
                'label' => empty($this->getModel()->id) ? "Create" : "Edit",
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]
        );

        if ($this->getModel() && $this->getModel()->id) {
            $url = route('user_update', $this->getModel()->id);
            $this->modify('email', 'email', [
                'label' => "E-mail address",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "E-mail address here",
                ],
                'rules' => [
                    'required',
                    'string',
                    'email',
                ],
                'error_messages' => [
                    'email.required' => "E-mail address is required.",
                    'email.string' => "E-mail address must be a string.",
                    'email.email' => "Invalid E-mail format.",
                ]
            ], true);
            empty($this->getModel()->deleted_at) ?: $this->remove('submit');
            $this->remove('password');
        } else {
            $url = route('user_store');
            $this->addAfter(
                'submit',
                'reset',
                'reset',
                [
                    'label' => 'Reset',
                    'attr' => [
                        'class' => 'btn btn-danger'
                    ]
                ]
            );
        }

        $this->formOptions = [
            'method' => empty($this->getModel()->id) ? "POST" : "PUT",
            'url' => $url,
        ];
    }
}
