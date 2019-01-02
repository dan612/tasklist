<?php

namespace Drupal\tasklist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends ControllerBase {

  public function clearTasks() {
    $connection = \Drupal::database();
    $task = $_POST['task'];
    $connection->update('tasks')
      ->fields([
        'status' => "cleared",
      ])
      ->condition('task', $task, '=')
      ->execute();
  
    return new Response("Tasks Cleared");
  }

}
