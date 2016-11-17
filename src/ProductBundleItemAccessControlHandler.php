<?php

namespace Drupal\commerce_product_bundle;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the product bundle item entity.
 *
 * @see \Drupal\commerce_product_bundle\Entity\ProductBundleItem.
 */
class ProductBundleItemAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\commerce_product_bundle\Entity\BundleItemInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished product bundle item entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published product bundle item entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit product bundle item entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete product bundle item entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add product bundle item entities');
  }

}