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

class CpfcnpjValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
        if (!$constraint->aceitar) {
            throw new ConstraintDefinitionException('É necessário definer a opção "aceitar" da restrição.');
        }

        if (!in_array($constraint->aceitar, array('cpf','cnpj','cpfcnpj'))) {
            throw new ConstraintDefinitionException('A opção "aceitar" pode conter apenas os valores "cpf", "cnpj" ou "cpfcnpj".');
        }

        if (null === $value) {
            return true;
        }

        switch ($constraint->aceitar) {

            case 'cnpj':
                if (!$this->checkCNPJ($value, $constraint->aceitar_formatado)) {
                    $this->setMessage($constraint->message_cnpj, array('{{ value }}' => $value));
                    return false;
                }
                break;

            case 'cpf':
                if (!$this->checkCPF($value, $constraint->aceitar_formatado)) {
                    $this->setMessage($constraint->message_cpf, array('{{ value }}' => $value));
                    return false;
                }
                break;

            case 'cpfcnpj':
            default:
                if (!($this->checkCPF($value, $constraint->aceitar_formatado) || $this->checkCNPJ($value, $constraint->aceitar_formatado))) {
                    $this->setMessage($constraint->message_cpfcnpj, array('{{ value }}' => $value));
                    return false;
                }
                break;

        }
        return true;
    }


    /**
     * checkCPF
     * Baseado em http://www.vivaolinux.com.br/script/Validacao-de-CPF-e-CNPJ/
     * Algoritmo em http://www.geradorcpf.com/algoritmo_do_cpf.htm
     * @param $cpf string
     * @author Rafael Goulart <rafaelgou@rgou.net>
     * Retirado do plugin do SF1 brFormExtraPlugin
     */
    protected function checkCPF($cpf, $aceitar_formatado) {

        // Limpando caracteres especiais
        if($aceitar_formatado){
            $cpf = $this->valueClean($cpf);
        }

        // Quantidade mínima de caracteres ou erro
        if (strlen($cpf) <> 11) return false;

        // Primeiro dígito
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += ((10-$i) * $cpf[$i]);
        }
        $d1 = 11 - ($soma % 11);
        if ($d1 >= 10) $d1 = 0;

        // Segundo Dígito
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += ((11-$i) * $cpf[$i]);
        }
        $d2 = 11 - ($soma % 11);
        if ($d2 >= 10) $d2 = 0;

        if ($d1 == $cpf[9] && $d2 == $cpf[10]) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * checkCNPJ
     * Baseado em http://www.vivaolinux.com.br/script/Validacao-de-CPF-e-CNPJ/
     * Algoritmo em http://www.geradorcnpj.com/algoritmo_do_cnpj.htm
     * @param $cnpj string
     * @author Rafael Goulart <rafaelgou@rgou.net>
     * Retirado do plugin do SF1 brFormExtraPlugin
     */
    protected function checkCNPJ($cnpj, $aceitar_formatado) {
        if($aceitar_formatado){
            $cnpj = $this->valueClean($cnpj);
        }
        if (strlen($cnpj) <> 14) return false;

        // Primeiro dígito
        $multiplicadores = array(5,4,3,2,9,8,7,6,5,4,3,2);
        $soma = 0;
        for ($i = 0; $i <= 11; $i++) {
            $soma += $multiplicadores[$i] * $cnpj[$i];
        }
        $d1 = 11 - ($soma % 11);
        if ($d1 >= 10) $d1 = 0;

        // Segundo dígito
        $multiplicadores = array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        $soma = 0;
        for ($i = 0; $i <= 12; $i++) {
            $soma += $multiplicadores[$i] * $cnpj[$i];
        }
        $d2 = 11 - ($soma % 11);
        if ($d2 >= 10) $d2 = 0;

        if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * valueClean
     * Retira caracteres especiais
     * @param $value string
     * @author Rafael Goulart <rafaelgou@rgou.net>
     * Retirado do plugin do SF1 brFormExtraPlugin
     */
    protected function valueClean ($value)
    {
        $value = str_replace (array(')','(','/','.','-',' '),'',$value);
        if(strlen($value) == 15)
        {
            $value =  substr($value, 1, 15);
        }
        return $value;
    }

}
