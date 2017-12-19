<?php

namespace Vesax\SEOBundle\RedirectRule;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\File\File;
use Vesax\SEOBundle\Entity\RedirectRule;

class BulkUploadHandler
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(RedirectRule::class);
    }

    /**
     * @param File $file
     * @throws \Exception
     */
    public function handleCSVFile(File $file)
    {
        $header = ['action', 'id', 'from', 'to', 'code'];

        $fp = $file->openFile('r');
        $n = 0;
        try {
            $this->em->beginTransaction();
            while ($row = $fp->fgetcsv()) {
                if (count($row) == 1) {
                    continue;
                }
                $n++;
                $assocRow = array_combine($header, $row);
                $assocRow['n'] = $n;
                try {
                    $this->handleRow($assocRow);
                } catch (\InvalidArgumentException $e) {
                    $message = sprintf('%s in row %d (%s)', $e->getMessage(), $n, join(',', $row));
                    throw new \InvalidArgumentException($message, $e->getCode(), $e);
                }
            }
            $this->em->commit();
        } catch (\Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }

    /**
     * @param array $row
     * @throws OptimisticLockException
     */
    private function handleRow(array $row)
    {
        if ($row['action'] == 'action' && $row['n'] == 1) {
            return;
        } elseif ($row['action'] == 'add') {
            $this->add($row['from'], $row['to'], $row['code']);
        } elseif ($row['action'] == 'delete') {
            $this->delete($row['id']);
        } elseif ($row['action'] == 'replace') {
            $this->replace($row['id'], $row['from'], $row['to'], $row['code']);
        } else {
            throw new \InvalidArgumentException(sprintf('Unknown action: %s', $row['action']));
        }
    }

    /**
     * @param string $from
     * @param string $to
     * @param int $code
     * @throws OptimisticLockException
     */
    private function add($from, $to, $code)
    {
        if (!$from || !$to || !$code) {
            throw new \InvalidArgumentException('Source, destination and code are required for add operation');
        }
        $redirectRule = new RedirectRule();
        $redirectRule->setSourceTemplate($from);
        $redirectRule->setDestination($to);
        $redirectRule->setCode($code);

        $this->em->persist($redirectRule);
        $this->em->flush($redirectRule);
    }

    /**
     * @param string $id
     * @throws OptimisticLockException
     */
    private function delete($id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Id is required for delete operation');
        }
        $redirectRule = $this->repo->find($id);
        if (!$redirectRule) {
            throw new \InvalidArgumentException(sprintf('Provided redirect ID %s doesn\'t exist', $id));
        }

        $this->em->remove($redirectRule);
        $this->em->flush($redirectRule);
    }

    /**
     * @param string $id
     * @param string $from
     * @param string $to
     * @param string $code
     * @throws OptimisticLockException
     */
    private function replace($id, $from, $to, $code)
    {
        if (!$id || !$from || !$to || !$code) {
            throw new \InvalidArgumentException('Id, source, destination and code are required for add operation');
        }
        $redirectRule = $this->repo->find($id);
        if (!$redirectRule) {
            throw new \InvalidArgumentException(sprintf('Provided redirect id %s doesn\'t exist', $id));
        }
        $redirectRule->setSourceTemplate($from);
        $redirectRule->setDestination($to);
        $redirectRule->setCode($code);

        $this->em->persist($redirectRule);
        $this->em->flush($redirectRule);
    }

}