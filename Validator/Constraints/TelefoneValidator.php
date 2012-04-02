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

class TelefoneValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        if (!$constraint->aceitar) {
            throw new ConstraintDefinitionException('É necessário definer a opção "aceitar" da restrição.');
        }

        if (!in_array($constraint->aceitar, array('dddtelefone','telefone'))) {
            throw new ConstraintDefinitionException('A opção "aceitar" pode conter apenas os valores "dddtelefone" ou "telefone".');
        }

        if (null === $value) {
            return true;
        }

        switch ($constraint->aceitar) {

            case 'dddtelefone':
                if ($this->checkDddTelefone($value, $constraint->aceitar_formatado)==1) {
                    if($constraint->aceitar_formatado){
                        $this->setMessage($constraint->message_dddtelefone_formatado, array('{{ value }}' => $value));
                    } else {
                        $this->setMessage($constraint->message_dddtelefone, array('{{ value }}' => $value));
                    }
                    return false;
                } elseif ($this->checkDddTelefone($value, $constraint->aceitar_formatado)==2){
                    $this->setMessage($constraint->message_ddd);
                    return false;
                }
                break;

            case 'telefone':
            default:
                if (!$this->checkTelefone($value, $constraint->aceitar_formatado)) {
                    if($constraint->aceitar_formatado){
                        $this->setMessage($constraint->message_telefone_formatado, array('{{ value }}' => $value));
                    } else {
                        $this->setMessage($constraint->message_telefone, array('{{ value }}' => $value));
                    }
                    return false;
                }
                break;

        }
        return true;
    }


    private function checkDddTelefone($value, $aceitar_formatado){

        if($aceitar_formatado){
            $phone_number_pattern = '/^(^(1\s*[-\/\.]?)?(\((\d{2})\)|(\d{2}))\s*[-\/\.]?\s*(\d{4})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$)*$/';
        } else {
            $phone_number_pattern = '/^(\d{10})*$/';
        }

        // If the value isn't a phone number, throw an error.
        if (!preg_match($phone_number_pattern, $value))
        {
            return 1;
        }

        // Take out anything that's not a number.
        $clean = preg_replace('/[^0-9]/', '', $value);

        $first_part = substr($clean, 0, 2);

        if(!DddValidator::inDDDs($first_part)){
            return 2;
        }

        return 0;

    }

    private function checkTelefone($value, $aceitar_formatado){

        if($aceitar_formatado){
            $phone_number_pattern = '/^(\s*(\d{4})\s*[-\/\.]?\s*(\d{4})\s*(([xX]|[eE][xX][tT])\.?\s*(\d+))*$)*$/';
        } else {
            $phone_number_pattern = '/^(\d{8})$/';
        }

        // If the value isn't a phone number, throw an error.
        if (!preg_match($phone_number_pattern, $value))
        {
            return false;
        }

        return true;

    }

}
