<?php

namespace App\Entity;


use Serializable;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("username", message="Ce pseudo est déjà utilisé")
 * @UniqueEntity("email", message="Cette email est déjà utilisée")
 * 
 */
class Membre implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Regex(
     *  pattern="/^(?=.{1,40}$)[a-zA-Z]+(?:[-'][a-zA-Z]+)*$/",
     *  message="Prénom invalide"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Regex(
     *  pattern="/^(?=.{1,40}$)[a-zA-Z]+(?:[-'][a-zA-Z]+)*$/",
     *  message="Nom invalide"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\Length(min="3", minMessage="Le pseudo doit contenir entre 3 et 20 caractères")
     * @Assert\Length(max="20", maxMessage="Le pseudo doit contenir entre 3 et 20 caractères")
     * @Assert\Regex(
     *  pattern="/^[a-zA-Z0-9]+(?:[_-]?[a-zA-Z0-9])*$/",
     *  message="Le pseudo est invalide"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     * @Assert\Regex(
     *  pattern="/^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}/",
     *  message="L'adresse email est invalide"
     * )
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     */
    private $dateTimeRegistry;

    /**
     * @ORM\Column(type="string", length=300)
     * @Assert\Length(min="8", minMessage="Le mot de passe doit contenir au minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas")
     */
    public $confirm_password;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="role", type="string", length=60, nullable=false)
     */
    private $role = 'ROLE_USER';

    /**
     * @var string
     *
     *
     * @ORM\Column(name="salt", type="string", length=60, nullable=true)
     */
    private $salt = NULL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture = 'anonymous.jpg';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     */
    private $comments;

    private $file;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author", orphanRemoval=true)
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }




    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     */
    public function initializeSlug()
    {
        if(empty($this->slug))
        {   
            $slugify = new Slugify();  
            $this->slug = $slugify->slugify($this->username);  
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        if($picture != NULL){
        $this->picture = $picture;
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateTimeRegistry(): ?\DateTimeInterface
    {
        return $this->dateTimeRegistry;
    }

    public function setDateTimeRegistry(?\DateTimeInterface $dateTimeRegistry): self
    {
        $this->dateTimeRegistry = $dateTimeRegistry;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $username): self
    {
        $this->password = $username;

        return $this;
    }


    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getRoles()
    {
        return $this->roles = [$this->role];
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt()
    {
        $this->salt = $salt;

        return $this;
    }

    public function eraseCredentials()
    { }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    public function uploadPicture()
    {
        //Renommer le fichier
        $nom = $this-> file ->getClientOriginalName();

        // $_FILES['photo']['name']
        $new_nom=$this->renamePicture($nom);


        // L'enregistrer en BDD
        $this -> picture = $new_nom;

        // Déplacer la data : enregistrer le fichier sur le serveur
        $this->file->move($this -> dirPicture(), $new_nom);
        // Arg 1 : le dossier
        // Arg 2 : nom du fichier
    }

    public function renamePicture($nom)
    {
        return 'photo_' .time() . '_' .rand(1,99999) . '_' . $nom;
        // -> chat.jpg
        // -> photo_1500000000_75642_chat.jpg
    }

    public function removePicture()
    {
        $file = $this ->dirPicture(). $this ->getPicture();
        //Chemin absolu de la photo à supprimer
        if(file_exists($file) && $this->getPicture() != 'anonymous.jpg')
        {
            unlink($file);
        }
    }

    public function dirPicture()
    {
        return __DIR__ . '/../../public/img/';
        // __DIR__ : chemin absolue du dossier dans lequel nous sommes
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file=$file;
        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }
 
    /**
     * Permet de recharger l'utilisateur à partir de la session
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt
        ) = unserialize($serialized);
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken(?string $resetToken): void
    {
        $this->resetToken = $resetToken;
    }

    

}
