<?php

namespace Vesax\SEOBundle\EventListener;

use Doctrine\Common\Cache\Cache;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Vesax\SEOBundle\Matcher\RedirectRuleMatcher;
use Vesax\SEOBundle\RedirectRule\RedirectRuleRepositoryInterface;

/**
 * Class RedirectListener
 *
 * @package Vesax\SEOBundle\EventListener
 * @author Artur Vesker
 */
class RedirectListener implements EventSubscriberInterface
{

    /**
     * @var RedirectRuleRepositoryInterface
     */
    protected $redirectRuleRepository;

    /**
     * @var RedirectRuleMatcher
     */
    protected $redirectRuleMatcher;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * RedirectListener constructor.
     *
     * @param RedirectRuleRepositoryInterface $redirectRuleRepository
     * @param RedirectRuleMatcher $redirectRuleMatcher
     * @param Cache $cache
     */
    public function __construct(RedirectRuleRepositoryInterface $redirectRuleRepository, RedirectRuleMatcher $redirectRuleMatcher, Cache $cache = null)
    {
        $this->redirectRuleRepository = $redirectRuleRepository;
        $this->redirectRuleMatcher = $redirectRuleMatcher;
        $this->cache = $cache;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$rule = $this->getRuleForPath($event->getRequest()->getPathInfo())) {
            return;
        }



        dump($rule);
        die();
    }

    private function getRuleForPath($path)
    {
        if ($this->cache) {
            if ($cachedRedirectRule = $this->cache->fetch($path)) {
                return $cachedRedirectRule;
            }
        }

        $rule = $this->redirectRuleMatcher->match($path, $this->redirectRuleRepository->findAllSortedByPriority());

        if (!$rule) {
            return null;
        }

        if ($this->cache) {
            $this->cache->save($path, $rule);
        }

        return $rule;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }

}