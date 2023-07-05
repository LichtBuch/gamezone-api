<?php

namespace App\Doctrine;

use App\Entity\User;

interface IOwner {

    public function getOwner(): ?User;
    public function setOwner(?User $owner): self;

}
