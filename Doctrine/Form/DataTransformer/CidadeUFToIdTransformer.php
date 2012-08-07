<?php
/**
 * This file is part of the Duo Criativa software.
 *
 * (c) Paulo Ribeiro <paulo@duocriativa.com.br>
 *
 * Date: 1/31/12
 * Time: 12:08 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BFOS\BrasilBundle\Doctrine\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Util\PropertyPath;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CidadeUFToIdTransformer implements DataTransformerInterface
{

    /**
     * Transforms the Cidade entity to a composed (estado,cidade_id) array value in the form
     *
     * @param $entity
     * @return int|null
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function transform($entity)
    {
        if (null === $entity || '' === $entity) {
            return null;
        }

        if (!is_object($entity)) {
            throw new UnexpectedTypeException($entity, 'object');
        }
        return array('estado'=>$entity->getUf(), 'cidade'=>$entity->getId());

    }

    /**
     * Takes an
     * @param $key
     * @return null
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function reverseTransform($key)
    {
        if ('' === $key || null === $key || !isset($key['cidade']) || !isset($key['estado']) ) {
            return null;
        }

        if (!is_object($key['cidade'])) {
            throw new TransformationFailedException(sprintf('Cidade não é um objeto válido.', $key));
        }

        if (!is_string($key['estado'])) {
            throw new TransformationFailedException(sprintf('UF não é um texto válido.', $key));
        }

        if ($key['cidade']->getUf()!=$key['estado']) {
            throw new TransformationFailedException(sprintf('Cidade [%s] não pertence ao estado [%s].', $key['cidade']->getNome(), $key['estado']));
        }

        return $key['cidade'];
    }
}