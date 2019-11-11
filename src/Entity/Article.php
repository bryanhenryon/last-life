<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTimePublication;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTimeEdition;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="text")
     */
    private $firstParagraph;

    /**
     * @ORM\Column(type="text")
     */
    private $secondParagraph;

    /**
     * @ORM\Column(type="text")
     */
    private $thirdParagraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstImage = 'placehold.jpg';

    /**
     * @ORM\Column(type="text")
     */
    private $fourthParagraph;

    /**
     * @ORM\Column(type="text")
     */
    private $fifthParagraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondImage = 'placehold.jpg';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $textPreview;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePreview = 'placehold.jpg';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titlePreview;

    private $file;

    private $fileun;

    private $filedeux;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre", inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(name="categorie", type="string", length=20, nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $video;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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
            $this->slug = $slugify->slugify($this->titre);  
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }


    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDateTimePublication(): ?\DateTimeInterface
    {
        return $this->dateTimePublication;
    }

    public function setDateTimePublication(?\DateTimeInterface $dateTimePublication): self
    {
        $this->dateTimePublication = $dateTimePublication;

        return $this;
    }

    public function getDateTimeEdition(): ?\DateTimeInterface
    {
        return $this->dateTimeEdition;
    }

    public function setDateTimeEdition(?\DateTimeInterface $dateTimeEdition): self
    {
        $this->dateTimeEdition = $dateTimeEdition;

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
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function getFirstParagraph(): ?string
    {
        return $this->firstParagraph;
    }

    public function setFirstParagraph(string $firstParagraph): self
    {
        $this->firstParagraph = $firstParagraph;

        return $this;
    }

    public function getSecondParagraph(): ?string
    {
        return $this->secondParagraph;
    }

    public function setSecondParagraph(string $secondParagraph): self
    {
        $this->secondParagraph = $secondParagraph;

        return $this;
    }

    public function getThirdParagraph(): ?string
    {
        return $this->thirdParagraph;
    }

    public function setThirdParagraph(string $thirdParagraph): self
    {
        $this->thirdParagraph = $thirdParagraph;

        return $this;
    }

    public function getFirstImage(): ?string
    {
        return $this->firstImage;
    }

    public function setFirstImage(string $firstImage): self
    {
        if($firstImage != NULL){
        $this->firstImage = $firstImage;
        }
        return $this;
        
    }

    public function getFourthParagraph(): ?string
    {
        return $this->fourthParagraph;
    }

    public function setFourthParagraph(string $fourthParagraph): self
    {
        $this->fourthParagraph = $fourthParagraph;

        return $this;
    }

    public function getFifthParagraph(): ?string
    {
        return $this->fifthParagraph;
    }

    public function setFifthParagraph(string $fifthParagraph): self
    {
        $this->fifthParagraph = $fifthParagraph;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->secondImage;
    }

    public function setSecondImage(string $secondImage): self
    {
        if($secondImage != NULL){
        $this->secondImage = $secondImage;
        }

        return $this;
    }

    public function getTextPreview(): ?string
    {
        return $this->textPreview;
    }

    public function setTextPreview(string $textPreview): self
    {
        $this->textPreview = $textPreview;

        return $this;
    }

    public function getImagePreview(): ?string
    {
        return $this->imagePreview;
    }

    public function setImagePreview(string $imagePreview): self
    {
        if($imagePreview != NULL){
        $this->imagePreview = $imagePreview;
        }

        return $this;
    }

    public function getTitlePreview(): ?string
    {
        return $this->titlePreview;
    }

    public function setTitlePreview(string $titlePreview): self
    {
        $this->titlePreview = $titlePreview;

        return $this;
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

    public function getFileUn()
    {
        return $this->fileun;
    }

    public function setFileUn(UploadedFile $fileun)
    {
        $this->fileun=$fileun;
        return $this;
    }

    public function getFileDeux()
    {
        return $this->filedeux;
    }

    public function setFileDeux(UploadedFile $filedeux)
    {
        $this->filedeux=$filedeux;
        return $this;
    }

    public function uploadImagePreview()
    {
        //Renommer le fichier
        $nom = $this-> file ->getClientOriginalName();

        // $_FILES['photo']['name']
        $new_nom=$this->renamePhoto($nom);


        // L'enregistrer en BDD
        $this -> imagePreview = $new_nom;

        // Déplacer la data : enregistrer le fichier sur le serveur
        $this->file->move($this -> dirPhoto(), $new_nom);
        // Arg 1 : le dossier
        // Arg 2 : nom du fichier
    }

    public function uploadFirstImage()
    {
        //Renommer le fichier
        $nom = $this-> fileun ->getClientOriginalName();

        // $_FILES['photo']['name']
        $new_nom=$this->renameFirstImage($nom);


        // L'enregistrer en BDD
        $this -> firstImage = $new_nom;

        // Déplacer la data : enregistrer le fichier sur le serveur
        $this->fileun->move($this -> dirPhoto(), $new_nom);
        // Arg 1 : le dossier
        // Arg 2 : nom du fichier
    }

    public function uploadSecondImage()
    {
        //Renommer le fichier
        $nom = $this-> filedeux ->getClientOriginalName();

        // $_FILES['photo']['name']
        $new_nom=$this->renameSecondImage($nom);


        // L'enregistrer en BDD
        $this -> secondImage = $new_nom;

        // Déplacer la data : enregistrer le fichier sur le serveur
        $this->filedeux->move($this -> dirPhoto(), $new_nom);
        // Arg 1 : le dossier
        // Arg 2 : nom du fichier
    }

    public function renamePhoto($nom)
    {
        return 'photo_' .time() . '_' .rand(1,99999) . '_' . $nom;
        // -> chat.jpg
        // -> photo_1500000000_75642_chat.jpg
    }

    public function renameFirstImage($nom)
    {
        return 'photo_' .time() . '_' .rand(1,99999) . '_' . $nom;
        // -> chat.jpg
        // -> photo_1500000000_75642_chat.jpg
    }

    public function renameSecondImage($nom)
    {
        return 'photo_' .time() . '_' .rand(1,99999) . '_' . $nom;
        // -> chat.jpg
        // -> photo_1500000000_75642_chat.jpg
    }
    
    public function removePhoto()
    {
        $file = $this ->dirPhoto(). $this ->getImagePreview();
        //Chemin absolu de la photo à supprimer
        if(file_exists($file) && $this->getImagePreview() != 'placehold.jpg')
        {
            unlink($file);
        }
    }

    public function removeFirstImage()
    {
        $file = $this ->dirPhoto(). $this ->getFirstImage();
        //Chemin absolu de la photo à supprimer
        if(file_exists($file) && $this->getFirstImage() != 'placehold.jpg')
        {
            unlink($file);
        }
    }

    public function removeSecondImage()
    {
        $file = $this ->dirPhoto(). $this ->getSecondImage();
        //Chemin absolu de la photo à supprimer
        if(file_exists($file) && $this->getSecondImage() != 'placehold.jpg')
        {
            unlink($file);
        }
    }

    public function dirPhoto()
    {
        return __DIR__ . '/../../public/img/';
        // __DIR__ : chemin absolue du dossier dans lequel nous sommes
    }

    public function getAuthor(): ?Membre
    {
        return $this->author;
    }

    public function setAuthor(?Membre $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }
}
