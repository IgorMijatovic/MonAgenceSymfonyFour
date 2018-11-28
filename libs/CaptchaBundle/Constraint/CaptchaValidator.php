<?php

namespace Imij\CaptchaBundle\Constraint;


use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CaptchaValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ReCaptcha
     */
    private $captcha;

    public function __construct(RequestStack $requestStack, ReCaptcha $captcha)
    {
        $this->requestStack = $requestStack;
        $this->captcha = $captcha;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $captchaResponse = $request->request->get('g-recaptcha-response');
        if (empty($captchaResponse)) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }
        $reponse = $this->captcha
                ->setExpectedHostname($request->getHost())
                ->verify($captchaResponse, $request->getClientIp());

        if(!$reponse->isSuccess()) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }
     }
}