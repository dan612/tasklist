<?php

  /**
   * @file
   * Contains \Drupal\tasklist\Form\TaskForm.
   */

  namespace Drupal\tasklist\Form;

  use Drupal\Core\Form\FormBase;
  use Drupal\Core\Form\FormStateInterface;

   class taskForm extends FormBase {
     /**
      * {@inheritdoc}
     */
     public function getFormId() {
       return 'task_form';
     }

     /**
      * {@inheritdoc}
     */

     public function buildForm(array $form, FormStateInterface $form_state) {

       $userid = \Drupal::currentUser()->id();

       $form['task'] = [
         '#type' => 'textfield',
       ];

       $form['user'] = [
         '#type' => 'hidden',
         '#value' => $userid,
       ];

       $form['actions']['#type'] = 'actions';
       $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('+ Add New Task'),
       ];
       return $form;
     }

     /**
      * {@inheritdoc}
     */

     public function validateForm(array &$form, FormStateInterface $form_state) {
       // Add validation rules in here.
     }

     /**
      * {@inheritdoc}
     */

     public function submitForm(array &$form, FormStateInterface $form_state) {

       $connection = \Drupal::database();

       $user = $form_state->getValues()['user'];
       $task = $form_state->getValues()['task'];
       $time = date('Y-m-d g:i:s');

       $connection->insert('tasks')->fields([
          'uid' => $user,
          'task' => $task,
          'status' => "New",
          'created' => $time,
          'closed' => 0,
        ])
        ->execute();
       drupal_set_message($this->t("Task Added"));
   }
 }
