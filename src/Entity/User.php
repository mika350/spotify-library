<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 *
 * @author Mika Bertels <mail@mikabertels.de>
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @var array
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string")
     * @var string The hashed password
     */
    private string $password;

    /**
     * @ORM\Column(type="text")
     * @var string The access token from Spotify
     */
    private string $spotifyAccessToken;

    /**
     * @ORM\Column(type="text")
     * @var string The refresh token from Spotify
     */
    private string $spotifyRefreshToken;

    /**
     * @return string
     */
    public function getSpotifyAccessToken(): string
    {
        return $this->spotifyAccessToken;
    }

    /**
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
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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
     * @see UserInterface
     *
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return string
     */
    public function getSpotifyRefreshToken(): string
    {
        return $this->spotifyRefreshToken;
    }

    /**
     * @param string $spotifyRefreshToken
     */
    public function setSpotifyRefreshToken(string $spotifyRefreshToken): self
    {
        $this->spotifyRefreshToken = $spotifyRefreshToken;

        return $this;
    }
}
