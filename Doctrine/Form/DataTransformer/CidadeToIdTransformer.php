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

class CidadeToIdTransformer implements DataTransformerInterface
{

    protected $em;
    protected $class;
    protected $propertyPath;

    public function __construct(EntityManager $em, $class, $property = null)
    {
         $this->em = $em;
         $this->class = $class;

         // The property option defines, which property (path) is used for
         // displaying entities as strings
        if ($property) {
             $this->propertyPath = new PropertyPath($property);
        }
    }


    /**
     * Transforms the Cidade entity to a composed (estado,cidade_id) array value in the form
     *
     * @param $entity
     * @return array|mixed|null|string
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
        return array('estado'=>$entity->getUf(), 'cidade'=>$entity);

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
          if ('' === $key['cidade'] || null === $key['cidade']) {
          return null;
          }

         if (!is_array($key))
         {
             return null;
         }

         if (!isset($key['estado']) || !isset($key['cidade']))
         {
             throw new TransformationFailedException(sprintf('The key "%s" is not valid', print_r($key,true)));
         }

         if (is_numeric($key['cidade']))
         {
             $entity = $this->em->getRepository($this->class)->findOneById($key['cidade']);
         } else {
             $entity = $key['cidade'];
         }

//        return $key['cidade'];



         if ($entity === null) {
             throw new TransformationFailedException(sprintf('The entity with key "%s" could not be found', $key));
         }

        return $entity;
    }
}