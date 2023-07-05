<?php

namespace App\Doctrine;

interface IDeleted {

    public function isDeleted(): ?bool;

    public function setDeleted(bool $deleted): self;

}
