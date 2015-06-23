<?php
namespace AppBundle\Communication\Email;

/**
 * Interface ProviderInterface
 *
 * @package AppBundle\Communication\Email
 */
/**
 * Interface ProviderInterface
 *
 * @package AppBundle\Communication\Email
 */
interface ProviderInterface
{
    /**
     * @param Message $message
     *
     * @return mixed
     */
    public function send(Message $message);
}