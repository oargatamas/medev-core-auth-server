<?php
/**
 * Created by PhpStorm.
 * User: Oarga-Tamas
 * Date: 2018. 09. 14.
 * Time: 15:03
 */

namespace MedevAuth\Services\Auth\OAuth\Entity;


use DateTime;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;

/**
 * Class AuthCode
 * @package MedevAuth\Services\Auth\OAuth\Entity
 */
class AuthCode extends DatabaseEntity
{

    /**
     * @var Client
     */
    private $client;
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $redirectUri;
    /**
     * @var DateTime
     */
    private $createdAt;
    /**
     * @var DateTime
     */
    private $expiresAt;
    /**
     * @var boolean
     */
    private $isRevoked;

    /**
     * @return Client
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client){
        $this->client = $client;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     */
    public function setExpiresAt(DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getRedirectUri(): string
    {
        if($this->redirectUri){
            return $this->client->getRedirectUri();
        }else{
            return $this->redirectUri;
        }

    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri(string $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @param Key $encryptionKey
     * @return string
     * @throws \Defuse\Crypto\Exception\EnvironmentIsBrokenException
     */
    public function finalizeAuthCode(Key $encryptionKey){
        $json = json_encode([
            "user_id" => $this->user->getIdentifier(),
            "client_id" => $this->client->getIdentifier(),
            "redirect_uri" => $this->redirectUri
        ]);
        return Crypto::encrypt($json,$encryptionKey);
    }

    /**
     * @return bool
     */
    public function isRevoked()
    {
        return $this->isRevoked;
    }

    /**
     * @param bool $isRevoked
     */
    public function setIsRevoked(bool $isRevoked)
    {
        $this->isRevoked = $isRevoked;
    }
}