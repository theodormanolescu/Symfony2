<?php
namespace AppBundle\Communication\Email;

/**
 * Class DevProvider
 *
 * @package AppBundle\Communication\Email
 */
class DevProvider implements ProviderInterface
{
    public function send(Message $message)
    {
        return true;
    }
}