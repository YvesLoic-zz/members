<?php

namespace App\Forms;

use App\Models\User;
use Kris\LaravelFormBuilder\Form;

class SchoolForm extends Form
{
    protected $clientValidationEnabled = false;

    public function buildForm()
    {
        $this->add(
            'name',
            'text',
            [
                'label' => "School name",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "School name here"
                ],
                'rules' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'error_messages' => [
                    'name.required' => "Scool name is required.",
                    'name.string' => "Scool name must be a string.",
                    'name.max' => "The max characters allowed for school name is :max.",
                ]
            ]
        )->add(
            'contact',
            'text',
            [
                'label' => "Phone number",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Phone number here",
                ],
                'rules' => [
                    'required',
                    'string',
                    'min:9',
                    'max:14',
                    'unique:schools',
                ],
                'error_messages' => [
                    'contact.required' => "Phone number is required.",
                    'contact.numeric' => "Phone number must be a string.",
                    'contact.min' => "Phone number minLenght is :min.",
                    'contact.max' => "Phone number maxLenght is :max.",
                    'contact.unique' => "Phone number already taken, please change it.",
                ]
            ]
        )->add(
            'user_id',
            'entity',
            [
                'label' => 'School director',
                'class' => User::class,
                'property' => 'name',
                'query_builder' => function (User $user) {
                    // return $user->where('rule', 'director');
                    return $user->where('deleted_at', null);
                }
            ]
        )->add(
            'description',
            'textarea',
            [
                'label' => "School description",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter some text here'
                ],
                'rules' => [
                    'required'
                ],
                'error_messages' => [
                    'description.required' => "Description is required."
                ]
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
            $url = route('school_update', $this->getModel()->id);
            $this->modify('contact', 'text', [
                'label' => "Phone number",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Phone number here",
                ],
                'rules' => [
                    'required',
                    'string',
                    'min:9',
                    'max:14',
                ],
                'error_messages' => [
                    'contact.required' => "Phone number is required.",
                    'contact.numeric' => "Phone number must be a string.",
                    'contact.min' => "Phone number minLenght is :min.",
                    'contact.max' => "Phone number maxLenght is :max.",
                ]
            ], true);
            empty($this->getModel()->deleted_at) ?: $this->remove('submit');
        } else {
            $url = route('school_store');
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
