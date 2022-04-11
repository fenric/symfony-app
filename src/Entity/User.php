<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(
 *   name="`user`",
 * )
 *
 * @ORM\Entity(
 *   repositoryClass="App\Repository\UserRepository",
 * )
 */
class User
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
     * Constructor of the class
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * Gets the user ID
     *
     * @return string
     */
    public function getId() : string
    {
    	return $this->id;
    }

    /**
     * Gets the user name
     *
     * @return string
     */
    public function getName() : string
    {
    	return $this->name;
    }

    /**
     * Sets the user name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name) : void
    {
    	$this->name = $name;
    }
}
