<?php

namespace Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity;

/**
 * Class WebAuthUserCredentials
 *
 * @package Maven\Bundle\MagentoBundle\API\DataProvider\FedEx\SOAP\Entity
 */
class WebAuthUserCredentials
{
    protected $Key;
    protected $Password;

    /**
     * WebAuthUserCredentials constructor.
     *
     * @param string $key
     * @param string $password
     */
    public function __construct($key = '', $password = '')
    {
        $this->Key = $key;
        $this->Password = $password;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey($key = '')
    {
        $this->Key = $key;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password = '')
    {
        $this->Password = $password;
        return $this;
    }

    /**
     * @return array
     */
    public function getUserCredentials()
    {
        return [
            'UserCredential' => get_object_vars($this)
        ];
    }
}
