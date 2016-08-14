<?php

namespace Vesax\SEOBundle\RedirectRule;

use Doctrine\ORM\EntityRepository;

/**
 * Class DoctrineRedirectRuleRepository
 *
 * @package Vesax\SEOBundle\RedirectRule
 * @author Artur Vesker
 */
class DoctrineRedirectRuleRepository extends EntityRepository implements RedirectRuleManagerInterface
{

    /**
     * @inheritdoc
     */
    public function findAllSortedByPriority()
    {
        return $this->findBy([], ['priority' => 'DESC']);
    }

    /**
     * @inheritdoc
     */
    public function save(RedirectRuleInterface $rule)
    {
        $em = $this->getEntityManager();
        $em->persist($rule);
        $em->flush($rule);
    }

}