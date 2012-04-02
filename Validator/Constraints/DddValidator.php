<?php
/*
 * This file is part of the BFOSBrasilBundle package.
 *
 * (c) Paulo Ribeiro <paulo@duocriativa.com.br>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BFOS\BrasilBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DddValidator extends ConstraintValidator
{
    public static $DDDs = array(68, 82, 96, 92, 97, 71, 73, 74, 75, 77, 85, 88, 61, 27, 28, 61, 62, 64, 98, 99, 65, 66, 67, 31, 32, 33, 34, 35, 37, 38, 91, 93, 94, 83, 41, 42, 43, 44, 45, 46, 81, 87, 86, 89, 21, 22, 24, 84, 51, 53, 54, 55, 69, 95, 47, 48, 49, 11, 12, 13, 14, 15, 16, 17, 18, 19, 79, 63);

    public function isValid($value, Constraint $constraint)
    {

        if (null === $value) {
            return true;
        }

        if (!self::inDDDs($value, self::$DDDs))
        {
            $this->setMessage($constraint->message);
           return false;
        }

        return true;
    }


    /**
     * Checks if a value is part of given choices (see bug #4212)
     *
     * @param  mixed $value   The value to check
     * @param  array $choices The array of available choices
     *
     * @return Boolean
     */
    static public  function inDDDs($value, array $choices = array())
    {
        if(count($choices)==0){
            $choices = self::$DDDs;
        }
        foreach ($choices as $choice)
        {
            if ((int) $choice == (int) $value)
            {
                return true;
            }
        }

        return false;
    }

}
