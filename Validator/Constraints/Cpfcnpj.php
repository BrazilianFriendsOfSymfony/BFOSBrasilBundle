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

/**
 * @Annotation
 */
class Cpfcnpj extends Constraint
{
    public $message_cpfcnpj = 'Este CPF/CPNJ é inválido';
    public $message_cpf = 'Este CPF é inválido';
    public $message_cnpj = 'Este CPNJ é inválido';
    public $aceitar = 'cpfcnpj';
    public $aceitar_formatado = true;
}
