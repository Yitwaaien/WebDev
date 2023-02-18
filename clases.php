<?php

class Cities {

    public  string $firstName;
    public ?string $lastName = null;
    public ?string $middleName = null;

    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName . ' ' . $this->middleName;
    }

}