<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PaidForm extends Form
{
    protected $clientValidationEnabled = false;

    public function buildForm()
    {
        $this->add(
            'code',
            'text',
            [
                'label' => 'Paiement Number',
                'attr' => [
                    'class' => 'form-control',
                    'disabled' => true
                ],
                'default_value' => $this->getData('code')
            ]
        )->add(
            'amount',
            'text',
            [
                'label' => "Amount",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Amount here"
                ],
                'rules' => [
                    'required',
                    'numeric',
                ],
                'error_messages' => [
                    'amount.required' => "Amount is required.",
                    'amount.numeric' => "Amount must be a string.",
                ]
            ]
        )->add(
            'student_id',
            'text',
            [
                'label' => 'Student number',
                'attr' => [
                    'class' => 'form-control',
                    'hidden' => true
                ],
                'label_show' => false,
                'default_value' => $this->getData('student')->id
            ]
        )->add(
            'user_id',
            'text',
            [
                'label' => 'User id',
                'attr' => [
                    'class' => 'form-control',
                    'hidden' => true
                ],
                'label_show' => false,
                'default_value' => $this->getData('user_id')
            ]
        )->add(
            'submit',
            'submit',
            [
                'label' => "Create",
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]
        )->add(
            'reset',
            'reset',
            [
                'label' => "Reset",
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]
        );

        $this->formOptions = [
            'method' => "POST",
            'url' => route('fees_store', $this->getData('student')->id),
        ];
    }
}
