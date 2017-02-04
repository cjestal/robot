<?php

  class Robot {
    
    private $posX = 0;
    private $posY = 0;
    private $direction = -1; // set a broken direction initially.
    
    public function setCoordinates ($x, $y) {
      $this->posX = $x;
      $this->posY = $y;
    }

    public function getCoordinates () {
      $coordinates = array(
        0 => $this->posX,
        1 => $this->posY
      );

      return $coordinates;
    }

    public function getPosX() {
      return $this->posX;
    }

    public function getPosY() {
      return $this->posY;
    }

    // $newDirection - takes non-numerical values N, E, W, S
    public function setDirection ($newDirection) {

      $directions = array(
        "N" => 0,
        "E" => 1,
        "S" => 2,
        "W" => 3
      );

      if ($this->direction == -1) {
        $this->direction = $directions[$newDirection]; //convert non-numeric character to int value for easier manipulation
      } else {
        
        if ($newDirection == 'R') { //rotate right
          $this->direction += 1;
        } elseif ($newDirection == 'L') { //rotate left
          $this->direction -= 1;
        }

        // Correct exceeding values
        if ($this->direction < 0) {
          $this->direction = 3;
        } elseif ($this->direction > 3) {
          $this->direction = 0;
        }
      }
    }

    public function getDirection () {
      return $this->direction; //TODO: to int or not to int?
    }

  }
?>