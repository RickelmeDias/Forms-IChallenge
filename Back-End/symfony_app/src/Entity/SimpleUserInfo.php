<?php

namespace App\Entity;

class SimpleUserInfo {
    // Properties
    public $complete_name;
    public $email;
  
    // Methods
    public function setName(string $new_name): self 
    {
        $this->complete_name = $new_name;

        return $this;
    }


    public function setEmail(string $new_email): self
    {
        $this->email = $new_email;

        return $this;
    }

}