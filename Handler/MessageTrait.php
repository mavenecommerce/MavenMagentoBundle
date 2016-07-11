<?php

namespace Maven\Bundle\MagentoBundle\Handler;

use Symfony\Component\HttpFoundation\Session\Session;

use Monolog\Logger;

use Oro\Bundle\TranslationBundle\Translation\Translator;

trait MessageTrait
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var.Session
     */
    protected $session;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param Translator $translator
     */
    public function setTranslator(Translator $translator = null)
    {
        $this->translator = $translator;
    }

    /**
     * @param Session $session
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $value
     * @param string $message
     */
    protected function setError($value, $message = 'maven_magento.errors.custom')
    {
        $message = $this->translator->trans($message, ['%value%' => $value]);
        $this
            ->session
            ->getFlashBag()
            ->add(
                'error',
                $message
            );

        $this->logger->error($message);
    }

    /**
     * @param string $value
     * @param string $message
     */
    protected function setSuccess($value, $message = 'maven_magento.messages.success')
    {
        $message = $this->translator->trans($message, ['%value%' => $value]);
        $this->session
            ->getFlashBag()
            ->add(
                'success',
                $message
            );
    }
}
