<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(
 *   indexes={
 *     @ORM\Index(fields={"createdAt"}),
 *   },
 * )
 *
 * @ORM\Entity(
 *   repositoryClass="App\Repository\ExportRepository",
 * )
 */
class Export
{

	/**
	 * @ORM\Id()
	 *
	 * @ORM\Column(
     *   type="string",
     *   length=36,
     *   options={
     *     "fixed"=true,
     *   },
     * )
	 *
	 * @var string
     *
     * @psalm-readonly
	 */
	private string $id;

	/**
	 * @ORM\Column(
	 *   type="string",
	 *   length="128",
	 * )
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=128)
	 *
	 * @var string
	 */
	private string $name = '';

    /**
     * @ORM\ManyToOne(
     *   targetEntity="Destination",
     * )
     *
     * @ORM\JoinColumn(
     *   onDelete="SET NULL",
     * )
     *
     * @Assert\NotNull()
     *
     * @var Destination|null
     */
    private ?Destination $destination = null;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="User",
     * )
     *
     * @ORM\JoinColumn(
     *   onDelete="SET NULL",
     * )
     *
     * @Assert\NotNull()
     *
     * @var User|null
     */
    private ?User $createdBy = null;

	/**
     * @ORM\Column(
     *   type="datetime_immutable",
     * )
     *
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $createdAt;

    /**
     * Constructor of the class
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
        $this->createdAt = new DateTimeImmutable('now');
    }

    /**
     * Gets the export ID
     *
     * @return string
     */
    public function getId() : string
    {
    	return $this->id;
    }

    /**
     * Gets the export name
     *
     * @return string
     */
    public function getName() : string
    {
    	return $this->name;
    }

    /**
     * Gets the export destination
     *
     * @return Destination|null
     */
    public function getDestination() : ?Destination
    {
    	return $this->destination;
    }

    /**
     * Gets the export creator
     *
     * @return User|null
     */
    public function getCreatedBy() : ?User
    {
    	return $this->createdBy;
    }

    /**
     * Gets the export's creation date
     *
     * @return DateTimeImmutable
     */
    public function getCreatedAt() : DateTimeImmutable
    {
    	return $this->createdAt;
    }

    /**
     * Sets the export name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name) : void
    {
    	$this->name = $name;
    }

    /**
     * Sets the export destination
     *
     * @param Destination|null $destination
     *
     * @return void
     */
    public function setDestination(?Destination $destination) : void
    {
    	$this->destination = $destination;
    }

    /**
     * Sets the export creator
     *
     * @param User|null $createdBy
     *
     * @return void
     */
    public function setCreatedBy(?User $createdBy) : void
    {
    	$this->createdBy = $createdBy;
    }

    /**
     * Sets the export's creation date
     *
     * @param DateTimeImmutable $createdAt
     *
     * @return void
     */
    public function setCreatedAt(DateTimeImmutable $createdAt) : void
    {
    	$this->createdAt = $createdAt;
    }
}
