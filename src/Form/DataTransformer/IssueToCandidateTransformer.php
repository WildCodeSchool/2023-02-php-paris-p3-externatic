<?php

namespace App\Form\DataTransformer;

use App\Entity\Candidate;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class IssueToCandidateTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Transforms an object (candidate) to a string (id).
     *
     * @param  Candidate|null $candidate
     */
    public function transform($candidate): string
    {
        if (null === $candidate) {
            return '';
        }

        return strval($candidate->getId());
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $candidateId
     * @throws TransformationFailedException if object (candidate) is not found.
     */
    public function reverseTransform($candidateId): ?Candidate
    {
        // no candidate id? It's optional, so that's ok
        if (!$candidateId) {
            return null;
        }

        $candidate = $this->entityManager
            ->getRepository(Candidate::class)
            // query for the issue with this id
            ->find($candidateId)
        ;

        if (null === $candidate) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'A candidate with id "%s" does not exist!',
                $candidateId
            ));
        }

        return $candidate;
    }
}
