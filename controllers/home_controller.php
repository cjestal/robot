<?php
  require_once('models/robot.php');

  class HomeController {
    
    public function index() {
      require_once('views/home/index.php');
    }

    public function submit () {
      $error = 0;

      if ($this->validateGridInputs($_POST['grid_parameters'])) {
        $grid = $this->createGrid($_POST['grid_parameters']);
      } else {
        $error = 1;
      }

      if ($this->validateRobotInputs($_POST['robot1_settings'])) {
        $robot1 = $this->createRobot($_POST['robot1_settings']);
      } else {
        $error = 2;
      }

      if ($this->validateRobotInputs($_POST['robot2_settings'])) {
        $robot2 = $this->createRobot($_POST['robot2_settings']);
      } else {
        $error = 3;
      }

      if ($error > 0) {
        $this->failed("Input error!");
      } else {
        $robot1Commands = $this->sanitizeRobotCommands($_POST['robot1_commands']);
        $robot2Commands = $this->sanitizeRobotCommands($_POST['robot2_commands']);
        $this->executeRobotCommands($robot1, $robot1Commands, $robot2, $robot2Commands, $grid);
      }


    }

    private function validateGridInputs ($input) {
      $input = explode(' ', $input);

      if (sizeof($input) != 2) {
        return false;
      } elseif (!is_numeric($input[0]) || !is_numeric($input[1])) {
        return false;
      } else {
        return true;
      }
    }

    private function validateRobotInputs ($input) {
      $input = explode(' ', strtoupper($input));
      $acceptableCharacters = ['N','E','W','S'];

      if (sizeof($input) != 3) {
        return false;
      } elseif (!is_numeric($input[0]) || !is_numeric($input[1])) {
        return false;
      } elseif (!in_array($input[2], $acceptableCharacters)) {
        return false;
      } else {
        return true;
      }

    }

    //remove unwanted characters
    private function sanitizeRobotCommands ($input) {
      $input = strtoupper($input);
      $input = str_split($input);
      $acceptableCharacters = ['L','M','R'];
      $cleanCommand = array();

      foreach ($input as $index) {
        if (in_array($index, $acceptableCharacters)) {
          array_push($cleanCommand, $index);
        }
      }

      return $cleanCommand;
    }

    //update the position of the robot
    private function move ($robot) {
      $direction = $robot->getDirection();
      $posX = $robot->getPosX();
      $posY = $robot->getPosY();

      if ($direction == 0) { //north
        $posX -= 1;
      } elseif ($direction == 1) { //east
        $posY += 1;
      } elseif ($direction == 2) { //south
        $posX += 1;
      } else { //west
        $posY -= 1;
      }

      $robot->setCoordinates($posX, $posY);
      return $robot;
    }

    private function changeDirection (&$robot, $newDirection) {
      $robot->setDirection($newDirection);
    }

    private function executeRobotCommands ($robot1, $command1, $robot2, $command2, $grid) {
      
      $robot1CommandCount = sizeof($command1);
      $robot2CommandCount = sizeof($command2);
      $loopLimit = $robot1CommandCount > $robot2CommandCount ? $robot1CommandCount : $robot2CommandCount;
      $countIndex = 0;
      $collisionFlag = false;

      while ($countIndex < $loopLimit && !$collisionFlag) {

        if ($command1[$countIndex] == 'M') {
          $robot1 = $this->move($robot1);
        }

        if ($command1[$countIndex] == 'R' || $command1[$countIndex] == 'L') {
          $this->changeDirection($robot1, $command1[$countIndex]);
        } else {
          //do nothing. wait for the other robot to stop or collide.
        }

        if ($command2[$countIndex] == 'M') {
          $robot2 = $this->move($robot2);
        } 

        if ($command2[$countIndex] == 'R' || $command2[$countIndex] == 'L') {
          $this->changeDirection($robot2, $command2[$countIndex]);
        } else {
          //do nothing. wait for the other robot to stop or collide.
        }

        $collisionFlag = $this->detectCollision($robot1, $robot2, $grid) != 0 ? true : false;
        $countIndex++;
      }

      if ($collisionFlag) {
        $this->failed("Robot Collision Detected!");
      } else {

        $directions = array('N','E', 'S', 'W');

        $robot1Final = "" . $robot1->getPosX() . " " . $robot1->getPosY() . " " . $directions[$robot1->getDirection()] . "";
        $robot2Final = "" . $robot2->getPosX() . " " . $robot2->getPosY() . " " . $directions[$robot2->getDirection()]. "";
        $this->success($robot1Final, $robot2Final);
      }


    }

    private function createGrid ($input) {
      $input = explode(' ', $input);
      $grid = new stdClass();
      $grid->minX = 0;
      $grid->minY = 0;
      $grid->maxX = $input[0];
      $grid->maxY = $input[1];

      return $grid;

    }

    private function createRobot ($settings) {
      $settings = explode(' ', strtoupper($settings));
      $robot = new Robot();
      $robot->setCoordinates($settings[0], $settings[1]);
      $robot->setDirection($settings[2]);
      return $robot;
    }

    private function detectCollision ($robot1, $robot2, $grid) {

      if ($robot1->getPosX() < 0 || $robot2->getPosX() < 0) { //check if beyond WEST boundary
        return 1;
      } elseif ($robot1->getPosY()< 0 || $robot2->getPosY() < 0) { //check if beyond NORTH boundary
        return 2;
      } elseif ($robot1->getPosX() > $grid->maxX || $robot2->getPosX() > $grid->maxX) { //check if beyond SOUTH boundary
        return 3;
      } elseif ($robot1->getPosY() > $grid->maxY || $robot2->getPosY() > $grid->maxY) { //check if beyond EAST boundary
        return 4;
      } else if ($robot1->getPosX() == $robot2->getPosX() && $robot1->getPosY() == $robot2->getPosY()) { //check collision between robots!
        return 5;
      } else { //no collision!
        return 0; 
      }
    }

    private function success ($robot1Final, $robot2Final) {
      require_once('views/home/success.php');
    }

    private function failed ($error) {
      require_once('views/home/failed.php');
    }

    public function error() {
      require_once('views/error.php'); //display an awesome 404 page!
    }
  }
?>