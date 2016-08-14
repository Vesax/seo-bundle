<?php
/**
 * @author Artur Vesker (arturvesker@gmail.com)
 */
namespace Vesax\SEOBundle\RedirectRule;

/**
 * Interface RedirectRuleManagerInterface
 */
interface RedirectRuleManagerInterface
{

    /**
     * @return RedirectRuleInterface[]
     */
    public function findAllSortedByPriority();

    /**
     * @param RedirectRuleInterface $rule
     */
    public function save(RedirectRuleInterface $rule);

}