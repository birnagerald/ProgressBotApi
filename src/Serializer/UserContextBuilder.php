<?php

namespace App\Serializer;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserContextBuilder implements SerializerContextBuilderInterface
{
    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     *
     * @param Request $request
     * @param boolean $normalization
     * @param array|null $extractedAttributes
     * @return array
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest(
            $request, $normalization, $extractedAttributes
        );

        //Class being serialized/deserialized
        $ressourceClass = $context['resource_class'] ?? null; //default to null if not set

        if (User::class ===$ressourceClass && isset($context['groups']) && $normalization === true && $this->authorizationChecker->isGranted('ROLE_ADMIN'))
        {
            $context['groups'][] = 'get-admin';
        }
        return $context;
    }

}