<?php

/**
 * @file
 * Contains \Drupal\rsvplist\Plugin\Block\RSVPBlock
 */

namespace Drupal\rsvplist\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'RSVP' List Block
 *
 * @Block(
 *   id = "rsvp_block",
 *   admin_label = @Translation("RSVP Block"),
 *   category = @Translation("Blocks")
 * )
 */
class RSVPBlock extends BlockBase
{
    /**
     * {@inheritDoc}
     */
    public function build()
    {
        return \Drupal::formBuilder()->getForm('Drupal\rsvplist\Form\RSVPForm');
    }
    /**
     * The blockAccess function controls when the block form will be displayed
     *
     * @param AccountInterface $account
     * @return void
     */
    public function blockAccess(AccountInterface $account)
    {
        /**
         *  @var \Drupal\node\Entity\Node $node
         */
        $node = \Drupal::routeMatch()->getParameter('node');

        /**
         *  @var \Drupal\rsvplist\EnablerService $enabler
         */
        //$enabler = \Drupal::service('rsvplist.enabler');

        if ($node instanceof \Drupal\node\NodeInterface) {
            // You can get nid and anything else you need from the node project

            $nid = $node->id();

            if (is_numeric($nid)) {
                //if ($enabler->isEnabled($node)) {
                    return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
                //}
            }
        }
        return AccessResult::forbidden();
    }
}
