BrasilBundle
============

Este bundle reúne componentes que são úteis no desenvolvimento de aplicativos web
com Symfony 2 no Brasil.

Componentes
===========

* Cidade/UF Form Type
Widget que possibilita o uso de cidade em seus formulários. Exibir dois combos ESTADO/CIDADE e o conteúdo de cidade
é carregado por Ajax.

* CPF/CNPJ Constraint Validator: Valida CPF/CPNJ nos seus objetos de domínio.

* Telefone Constraint Validator: Valida telefone nos seus objetos de domínio.

* DDD Constraint Validator: Valida DDD nos seus objetos de domínio.

Requisitos
==========

- jQuery

Instalação
==========

1. Adicione o arquivo de formulário do BrasilBundle

# Twig Configuration
twig:
    debug:            %kernel.debug%
    strict_variables: %kernel.debug%
    form:
        resources:
            - 'BFOSBrasilBundle:Form:form_div_layout.html.twig'


Utilização
==========

Cidade/UF Form Type
-------------------

Em seu FormType adicione o campo do tipo

$builder->add('cidade', 'bfos_cidade_choice');


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
