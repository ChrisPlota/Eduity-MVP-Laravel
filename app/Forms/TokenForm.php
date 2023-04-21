<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TokenForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email')
            ->add('password', 'password');
    }
}
