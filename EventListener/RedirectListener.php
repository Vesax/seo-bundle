<?php

namespace Vesax\SEOBundle\EventListener;

use Doctrine\Common\Cache\Cache;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;
use Vesax\SEOBundle\Matcher\RedirectRuleMatcher;
use Vesax\SEOBundle\RedirectRule\RedirectRuleManagerInterface;

/**
 * Class RedirectListener
 *
 * @package Vesax\SEOBundle\EventListener
 * @author Artur Vesker
 */
class RedirectListener
{

    /**
     * @var RedirectRuleManagerInterface
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
     * @param RedirectRuleManagerInterface $redirectRuleRepository
     * @param RedirectRuleMatcher $redirectRuleMatcher
     * @param Cache $cache
     */
    public function __construct(RedirectRuleManagerInterface $redirectRuleRepository, RedirectRuleMatcher $redirectRuleMatcher, Cache $cache = null)
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

        if (!$redirect = $this->getRedirectForRequest($event->getRequest())) {
            return;
        }

        $event->setResponse($redirect);
    }


    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onException(GetResponseForExceptionEvent $event)
    {
        if (!$event->getException() instanceof NotFoundHttpException) {
            return;
        }

        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$redirect = $this->getRedirectForRequest($event->getRequest())) {
            return;
        }

        $event->setResponse($redirect);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    protected function getRedirectForRequest(Request $request)
    {
        $path = $request->getPathInfo();

        if (!$rule = $this->getRuleForPath($path)) {
            return null;
        }

        return new RedirectResponse($rule->getDestination(), $rule->getCode());
    }

    /**
     * @param $path
     * @return null|\Vesax\SEOBundle\RedirectRule\RedirectRuleInterface
     */
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

        if ($rule->isStopped()) {
            return null;
        }

        if ($this->cache) {
            $this->cache->save($path, $rule);
        }

        return $rule;
    }
}