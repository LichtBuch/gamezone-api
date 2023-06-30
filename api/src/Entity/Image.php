<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateImageAction;
use App\Repository\ImageRepository;
use ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\OpenApi\Model;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: CreateImageAction::class,
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ],
                                    'game' => [
                                        'type' => 'int'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            ),
            validationContext: ['groups' => ['Default', 'image_create']],
            deserialize: false
        )
    ],
    normalizationContext: ['groups' => ['image:read']]
)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['image:read'])]
    private ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "image", fileNameProperty: "title")]
    #[Assert\NotNull(groups: ['image_create'])]
    private ?File $file = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContentUrl(): ?string {
        return $this->contentUrl;
    }

    /**
     * @param string|null $contentUrl
     * @return Image
     */
    public function setContentUrl(?string $contentUrl): self {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File {
        return $this->file;
    }

    /**
     * @param File|null $file
     * @return Image
     */
    public function setFile(?File $file): self {
        $this->file = $file;

        return $this;
    }

}
