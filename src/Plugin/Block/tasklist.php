<?php

namespace Drupal\tasklist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a Block for tasks.
 *
 * @Block(
 *   id = "tasklist",
 *   admin_label = @Translation("Tasklist"),
 *   category = @Translation("Tasklist"),
 * )
 */

class tasklist extends BlockBase {

  /**
   * {@inheritdoc}
  */

  public function build() {

    // Detect the current user
    $user = \Drupal::currentUser()->id();
    // Build form for adding new tasks
    // Form created in src/Form/TaskForm.php
    $form = \Drupal::formBuilder()->getForm('Drupal\tasklist\Form\TaskForm');
    // Show link to login if the user is detected as anonymous
    // Otherwise, get tasks for that user
    if ($user === 0) {
      $build = [
        '#suffix' => '<p>Please <a href="user/login">Login</a> To View Tasks</p>',
      ];
      return $build;
    }
    else {
      // Function to gather tasks associated with the logged in user
      function fetchTasks($uid){
        $connection = \Drupal::database();
        $query = $connection->query("SELECT task FROM tasks WHERE uid = $uid AND status='New'");
        $tasks_raw = $query->fetchAll();
        // Tasks are retrieved as array of objects
        // Cast VALUES ONLY to new array
        $tasks = array();
        foreach ($tasks_raw as $task) {
          array_push($tasks, $task->task);
        }
        return $tasks;
      }
      // Get tasks that have been added by the logged in user
      $list = fetchTasks($user);
      // Build block
      // Variables set in hook_theme() of .module file.
      $build = [
        '#theme' => 'tasklist',
        '#list' => $list,
        '#form' => $form,
        '#user' => $user,
        '#attached' => array(
          'library' => array(
            'tasklist/scripts',
            'tasklist/tasklist',
          )
        ),
      ];
      // Deny caching
      $build['#cache']['max-age'] = 0;
      return $build;
    }
  }
}
