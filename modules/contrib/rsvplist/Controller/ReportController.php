<?php
/**
 * @file
 * Contains \Drupal\rsvplist\Controller\ReportController
 */

//  namespace \Drupal\rsvplist\Controller;

//  use Drupal\Core\Controller\ControllerBase;
//  use Drupal\Core\Database\Database;

//  class ReportController extends ControllerBase
//  {
//      /**
//       * Gets all RSVPs for all nodes.
//       * Return array
//       */
//     protected function load()
//     {
//         $select = Database::getConnection()->select('rsvplist', 'r');
//         $select->join('users_field_data', 'u', 'r.uid = u.uid');
//         $select->addField('u', 'name', 'username');
//         $select->addField('n', 'title');
//         $select->addField('r', 'mail');
//         $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
//         return $entries;
//     }  
//  }