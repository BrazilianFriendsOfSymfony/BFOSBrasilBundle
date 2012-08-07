

CPF/CNPJ Constraint Validator
-----------------------------

Na sua classe a ser validada utilize

use BFOS\BrasilBundle\Validator\Constraints as BFOSBrasilAssert;

e na propriedade a ser validada

/**
 * @BFOSBrasilAssert\Cpfcnpj()
 */

 Parâmetros:

 - aceitar: cpfcnpj, cpf ou cnpf. cpfcnpj: pode conter CPF ou CNPJ válido; cpf: pode conter somente CPF válido; cnpj: pode conter somente CNPJ válido.
 - aceitar_formatado: true ou false . Determina se o telefone pode conter os caracteres de formatação.

Telefone Constraint Validator
-----------------------------

Na sua classe a ser validada utilize

use BFOS\BrasilBundle\Validator\Constraints as BFOSBrasilAssert;

e na propriedade a ser validada

/**
 * @BFOSBrasilAssert\Telefone()
 */

Parâmetros:

- aceitar: dddtelefone ou telefone . dddtelefone: o telefone tem que ter o DDD junto; telefone: somente o telefone é esperado, sem o DDD.
- aceitar_formatado: true ou false . Determina se o telefone pode conter os caracteres de formatação.

DDD Constraint Validator
-----------------------------

Na sua classe a ser validada utilize

use BFOS\BrasilBundle\Validator\Constraints as BFOSBrasilAssert;

e na propriedade a ser validada

/**
 * @BFOSBrasilAssert\Ddd()
 */
