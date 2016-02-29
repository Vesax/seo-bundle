<?php

namespace Vesax\SEOBundle\RedirectRule;

use Doctrine\ORM\EntityRepository;

/**
 * Class DoctrineRedirectRuleRepository
 *
 * @package Vesax\SEOBundle\RedirectRule
 * @author Artur Vesker
 */
class DoctrineRedirectRuleRepository extends EntityRepository implements RedirectRuleRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function findAllSortedByPriority()
    {
        return $this->findBy([], ['priority' => 'DESC']);
    }

}