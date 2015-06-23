<?php
namespace JsonRpcBundle;

/**
 * Class Response
 *
 * @package JsonRpcBundle
 */
abstract class Response
{
    const VERSION = '2.0';

    /**
     * @var
     */
    private $id;
    /**
     * @var string
     */
    private $jsonrpc = self::VERSION;
    /**
     * @var
     */
    private $resultKey;
    /**
     * @var
     */
    private $result;

    /**
     * @param $id
     * @param $resultKey
     * @param $result
     */
    public function __construct($id, $resultKey, $result)
    {
        $this->id = $id;
        $this->resultKey = $resultKey;
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJsonrpc()
    {
        return $this->jsonrpc;
    }

    /**
     * @return mixed
     */
    public function getResultKey()
    {
        return $this->resultKey;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $jsonrpc
     *
     * @return $this
     */
    public function setJsonrpc($jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
        return $this;
    }

    /**
     * @param $resultKey
     *
     * @return $this
     */
    public function setResultKey($resultKey)
    {
        $this->resultKey = $resultKey;
        return $this;
    }

    /**
     * @param $result
     *
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'id'                  => $this->getId(),
            'jsonrpc'             => $this->getJsonrpc(),
            $this->getResultKey() => $this->getResult()
        );
    }
}
