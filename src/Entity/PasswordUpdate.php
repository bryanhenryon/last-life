<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{

    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez indiquer votre mot de passe actuel")
     * 
     */
    private $oldPassword;

     /**
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au minimum 8 caractères")
     * @Assert\NotBlank(message="Veuillez indiquer votre nouveau mot de passe")
     */
    private $newPassword;

     /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Les mots de passe ne correspondent pas")
     * @Assert\NotBlank(message="Veuillez confirmer votre nouveau mot de passe")
     */
    private $confirmPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
