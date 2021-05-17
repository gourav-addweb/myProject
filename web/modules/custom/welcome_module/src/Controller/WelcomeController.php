<?php

namespace Drupal\welcome_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Link;


class WelcomeController extends ControllerBase {
  public function welcome() {
      $name = [
          '#markup' => 'page',
      ];
      return $name;
    // return array(
    //   '#markup' => 'Welcome to our Website.'
    // );
    //create table header
    $header_table = array(
        '#id'=> t(‘SrNo’),
        '#name' => t(‘Name’),
        '#mobilenumber' => t(‘MobileNumber’),
        '#email'=>t(‘Email’),
        '#age' => t(‘Age’),
        '#gender' => t(‘Gender’),
        // '#website' => t(‘Web site’),
        '#opt' => t(‘operations’),
        '#opt1' => t(‘operations’),
    );
    //display data in site
    $form[‘table’] = [
        // ‘#type’ => ‘table’,
        '#header' => $header_table,
        // ‘#rows’ => $rows,
        // ‘#empty’ => t(‘No users found’),
    ];
    return $form;    
  }

  public function display() {
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //crate table header
    $header_table = [
        'id' => t('SrNo'),
        'name' => t('name'),
        'mobileNumber' => t('mobileNumber'),
        'gender' => t('gender'),
        'email' => t('email'),
        'age' => t('age'),
        'gender' => t('gender'),
        'website' => t('website'),
        'opt' => t('Delete'),
        'opt1' => t('Edit'),
    ];

    //select data from database

    $query = \Drupal::database()->select('mydata', 'm');
    $query->fields('m', ['id', 'name', 'mobilenumber', 'email', 'age', 'gender', 'website']);
    $result = $query->execute()->fetchAll();

    $rows = array();

    foreach($result as $data) {
        $delete = Url::fromUserInput('/mydata/form/delete/'.$data->id);
        $edit = Url::fromUserInput('/mydata/form/mydata?num='.$data->id);

        //print the data from table
        $rows[] = [
            'id' => $data->id,
            'name' => $data->name,
            'mobilenumber' => $data->mobilenumber,
            'email' => $data->email,
            'age' => $data->age,
            'gender' => $data->gender,
            'website' => $data->website,

            // \Drupal::l('Delete', $delete),
            // \Drupal::l('Edit', $edit),
            Link::createFromRoute('Delete', 'entity.node.canonical', ['node' => 1]),
            Link::createFromRoute('Edit', 'entity.node.canonical', ['node' => 1]),
        ];
    }

    // display data in site
    $form = [
        '#type' => 'table',
        '#header' => $header_table,
        '#rows' => $rows,
        '#empty' => 'No user found'
    ];
    return $form;

  }
}

?>