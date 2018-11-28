<?php
namespace Imij\CaptchaBundle\Constraint;

use Symfony\Component\Validator\Constraint;

class Captcha extends Constraint
{
    public $message = 'Invalid captcha';
}