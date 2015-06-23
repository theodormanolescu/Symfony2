<?php
namespace AppBundle\Service;

use AppBundle\Communication\Email\Message;
use AppBundle\Communication\Email\ProviderInterface;

/**
 * Class EmailService
 *
 * @package AppBundle\Service
 */
class EmailService
{
    /**
     * @var array
     */
    private $providers = array();
    /**
     * @var int
     */
    private $providerIndex = -1;

    /**
     * @param ProviderInterface $provider
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * @param Message $message
     *
     * @return mixed
     */
    public function send(Message $message)
    {
        $this->incrementIndex();
        $provider = $this->providerIndex[$this->providerIndex];
        return $provider->send($message);
    }

    private function incrementIndex()
    {
        $this->providerIndex++;
        if ($this->providerIndex > count($this->providers) - 1) {
            $this->providerIndex = 0;
        }
    }
}