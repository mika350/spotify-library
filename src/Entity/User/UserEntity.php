<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class UserEntity implements UserInterface
{
    /**
     * The email address from an user.
     *
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private string $email;

    /**
     * The unique identifier from an user.
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue
     *
     * @var int
     */
    private int $id;

    /**
     * Indicator if the users profile is verified.
     *
     * @ORM\Column(type="boolean", nullable=false)
     *
     * @var bool
     */
    private bool $isVerified = false;

    /**
     * The name from an user.
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="json")
     *
     * @var array
     */
    private array $roles = [];

    /**
     * The hashed password from an user.
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private string $password;

    /**
     * The plain password from an user. DO NOT STORE IT ANYWHERE!
     *
     * @var string
     */
    private string $plainPassword;

    /**
     * The users access token from Spotify.
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    private ?string $spotifyAccessToken = null;

    /**
     * The users refresh token from Spotify
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string|null
     */
    private ?string $spotifyRefreshToken = null;

    /**
     * Erase sensitive data from an user.
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = '';
    }

    /**
     * Get the users email address.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Get the users identifier.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the users name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the users hashed password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Get the users roles.
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Get the users salt.
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Get the users Spotify access token.
     *
     * @return string
     */
    public function getSpotifyAccessToken(): string
    {
        return $this->spotifyAccessToken;
    }

    /**
     * Get the users Spotify refresh token.
     *
     * @return string
     */
    public function getSpotifyRefreshToken(): string
    {
        return $this->spotifyRefreshToken;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Check if the user is verified.
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * Set the users email address.
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set that the user is verified.
     *
     * @param bool $isVerified
     *
     * @return $this
     */
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Set the users name.
     *
     * @param string|null $name
     *
     * @return UserEntity
     */
    public function setName(?string $name): UserEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the users hashed password.
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the users roles.
     *
     * @param array $roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set the users Spotify token.
     *
     * @param string $spotifyAccessToken
     *
     * @return self
     */
    public function setSpotifyAccessToken(string $spotifyAccessToken): self
    {
        $this->spotifyAccessToken = $spotifyAccessToken;

        return $this;
    }

    /**
     * Set the users SpotifyRefreshToken
     *
     * @param string $spotifyRefreshToken
     *
     * @return self
     */
    public function setSpotifyRefreshToken(string $spotifyRefreshToken): self
    {
        $this->spotifyRefreshToken = $spotifyRefreshToken;

        return $this;
    }
}
