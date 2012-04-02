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
class Telefone extends Constraint
{
    public $message_ddd = 'DDD do telefone inválido.';
    public $message_dddtelefone = 'Telefone inválido. Utilize o formato 9999999999';
    public $message_telefone = 'Telefone inválido. Utilize o formato 99999999';
    public $message_dddtelefone_formatado = 'Telefone inválido. Utilize o formato (99)9999-9999';
    public $message_telefone_formatado = 'Telefone inválido. Utilize o formato 9999-9999';
    public $aceitar = 'dddtelefone';
    public $aceitar_formatado = true;
}
