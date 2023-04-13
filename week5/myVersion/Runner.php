<?php

class Runner
{
    public static int $nextId = 0;
    private int $id;
    private string $fName;
    private string $lName;
    private ?string $gender;
    private ?string $phone;

    /**
     * @param int|null $id
     * @param string $fName
     * @param string $lName
     * @param string|null $gender
     * @param string|null $phone
     */
    public function __construct(?int $id, string $fName, string $lName, ?string $gender, ?string $phone)
    {

        $this->id = $id ?: Runner::$nextId;
        Runner::$nextId = $id + 1;
        $this->fName = $fName;
        $this->lName = $lName;
        $this->gender = $gender;
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getFName(): int
    {
        return $this->fName;
    }

    /**
     * @param int $fName
     */
    public function setFName(int $fName): void
    {
        $this->fName = $fName;
    }

    /**
     * @return string
     */
    public function getLName(): string
    {
        return $this->lName;
    }

    /**
     * @param string $lName
     */
    public function setLName(string $lName): void
    {
        $this->lName = $lName;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }
}