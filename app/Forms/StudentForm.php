<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class StudentForm extends Form
{
    protected $clientValidationEnabled = false;

    public function buildForm()
    {
        $this->add('matricule', 'text', [
            'label' => 'Student Matricule',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student Matricule here"
            ],
            'rules' => [
                'required',
                'string',
            ],
            'error_messages' => [
                'matricule.required' => "Matricule is required.",
                'matricule.string' => "Matricule must be a string.",
            ]
        ])->add('first_name', 'text', [
            'label' => 'Student First name',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student First name here"
            ],
            'rules' => [
                'required',
                'string',
                'max:100',
                'min:2',
            ],
            'error_messages' => [
                'first_name.required' => "First name is required.",
                'first_name.string' => "First name must be a string.",
                'first_name.max' => "The max characters allowed for the first name is :max.",
                'first_name.min' => "The min characters allowed for the first name is :min.",
            ]
        ])->add('last_name', 'text', [
            'label' => 'Student Last name',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student Last name here"
            ],
            'rules' => [
                'required',
                'string',
                'max:100',
                'min:2',
            ],
            'error_messages' => [
                'last_name.required' => "Last name is required.",
                'last_name.string' => "Last name must be a string.",
                'last_name.max' => "The max characters allowed for the last name is :max.",
                'last_name.min' => "The min characters allowed for the last name is :min.",
            ]
        ])->add('class', 'text', [
            'label' => 'Student Class',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student Class here"
            ],
            'rules' => [
                'required',
                'string',
            ],
            'error_messages' => [
                'class.required' => "Class is required.",
                'class.string' => "Class must be a string.",
            ]
        ])->add('birthday', 'date', [
            'label' => 'Student Birthday',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student Birthday here"
            ],
            'rules' => [
                'required',
            ],
            'error_messages' => [
                'birthday.required' => "Birthday is required.",
            ]
        ])->add('birthplace', 'text', [
            'label' => 'Student Birthplace',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => "Student Birthplace here"
            ],
            'rules' => [
                'required',
                'string',
            ],
            'error_messages' => [
                'birthplace.required' => "Birthplace is required.",
                'birthplace.string' => "Birthplace must be a string.",
            ]
        ])->add('school_id', 'hidden', [
            'default_value' => $this->getData('id')
        ])->add(
            'sex',
            'choice',
            [
                'label' => "Student Sex",
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'M' => 'Male',
                    'F' => 'Female',
                ],
                'default_value' => 'M'
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
            $url = route('student_update', $this->getModel()->matricule);
            empty($this->getModel()->deleted_at) ?: $this->remove('submit');
        } else {
            $url = route('student_store', ['id' => $this->getData('id')]);
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
