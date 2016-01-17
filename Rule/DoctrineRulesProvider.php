<?php

namespace Vesax\SEOBundle\Rule;

use Doctrine\ORM\EntityRepository;

/**
 * Class DoctrineRulesProvider
 *
 * @package Vesax\SEOBundle\Rule
 * @author Artur Vesker
 */
class DoctrineRulesProvider implements RulesProviderInterface
{

    /**
     * @var EntityRepository
     */
    protected $em;

    /**
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function load()
    {
        return $this->repository->findBy([], ['priority' => 'DESC']);
    }

}