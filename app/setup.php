<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 07.08.16
 * Time: 13:42
 */
use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Component\HttpFoundation\Session\Session;

$this->session = new Session();
$csrfTokenManager = new CsrfTokenManager();

//$this->validator = Validation::createValidator();
$this->validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();


$this->translator = new Translator('en');
$this->translator->addLoader('xlf', new XliffFileLoader());
$this->translator->addResource('xlf', VENDOR_FORM_DIR . '/Resources/translations/validators.en.xlf', 'en', 'validators');
$this->translator->addResource('xlf', VENDOR_VALIDATOR_DIR . '/Resources/translations/validators.en.xlf', 'en', 'validators');

$this->twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
    PATH_VIEWS,
    VENDOR_TWIG_BRIDGE_DIR . '/Resources/views/Form',
)));
$formEngine = new TwigRendererEngine(array(DEFAULT_FORM_THEME));
$formEngine->setEnvironment($this->twig);
$this->twig->addExtension(new TranslationExtension($this->translator));
$this->twig->addExtension(
    new FormExtension(new TwigRenderer($formEngine, $csrfTokenManager))
);
$this->twig->addGlobal('session', $this->session);


$this->formFactory = Forms::createFormFactoryBuilder()
    ->addExtension(new CsrfExtension($csrfTokenManager))
    ->addExtension(new ValidatorExtension($this->validator))
    ->getFormFactory();
